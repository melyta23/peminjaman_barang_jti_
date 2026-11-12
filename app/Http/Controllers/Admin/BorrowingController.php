<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['details.item.category'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_transaksi', 'like', '%' . $request->q . '%')
                  ->orWhere('nama_peminjam', 'like', '%' . $request->q . '%')
                  ->orWhere('nim_nip', 'like', '%' . $request->q . '%');
            });
        }

        $borrowings = $query->paginate(15)->withQueryString();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['details.item.category', 'user'])->findOrFail($id);

        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $borrowing = Borrowing::with('details.item')->findOrFail($id);
        $oldStatus = $borrowing->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return back()->with('info', 'Status tidak berubah.');
        }

        DB::beginTransaction();
        try {
            // Logika pengelolaan ketersediaan stok
            // 1. Dari (menunggu/ditolak) -> disetujui (Barang dikeluarkan/dipinjam)
            if ($newStatus === 'disetujui' && $oldStatus !== 'disetujui') {
                foreach ($borrowing->details as $detail) {
                    $item = $detail->item;
                    if ($item->stok_tersedia < $detail->jumlah) {
                        DB::rollBack();
                        return back()->with('error', "Stok barang '{$item->nama_barang}' tidak cukup untuk disetujui.");
                    }
                    $item->decrement('stok_tersedia', $detail->jumlah);
                }
            }

            // 2. Dari disetujui -> selesai (Barang dikembalikan)
            if ($newStatus === 'selesai' && $oldStatus === 'disetujui') {
                foreach ($borrowing->details as $detail) {
                    $detail->item->increment('stok_tersedia', $detail->jumlah);
                }
                $borrowing->tanggal_pengembalian_aktual = now();
            }

            // 3. Dari disetujui -> ditolak / menunggu (Pembatalan persetujuan sebelumnya)
            if (($newStatus === 'ditolak' || $newStatus === 'menunggu') && $oldStatus === 'disetujui') {
                foreach ($borrowing->details as $detail) {
                    $detail->item->increment('stok_tersedia', $detail->jumlah);
                }
                $borrowing->tanggal_pengembalian_aktual = null;
            }

            $borrowing->status = $newStatus;
            if ($request->filled('catatan_admin')) {
                $borrowing->catatan_admin = $request->catatan_admin;
            }
            $borrowing->save();

            DB::commit();

            return back()->with('success', "Status peminjaman {$borrowing->kode_transaksi} berhasil diubah menjadi " . strtoupper($newStatus));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

