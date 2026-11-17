<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with('details.item')->latest();

        if (Auth::check() && !Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('kode')) {
            $query->where('kode_transaksi', 'like', '%' . $request->kode . '%');
        }

        if ($request->filled('nim')) {
            $query->where('nim_nip', 'like', '%' . $request->nim . '%');
        }

        $borrowings = $query->paginate(10)->withQueryString();

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $categories = Category::with(['items' => function ($query) {
            $query->orderBy('nama_barang', 'asc');
        }])->get();
        $user = Auth::user();

        return view('borrowings.create', compact('categories', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'nim_nip' => 'required|string|max:50',
            'prodi' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'jam_mulai' => 'nullable|string|max:20',
            'jam_selesai' => 'nullable|string|max:20',
            'sampai_selesai' => 'nullable',
            'keperluan' => 'required|string|min:10',
            'lokasi_penggunaan' => 'nullable|string|max:255',
            'category_id' => 'nullable',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|exists:items,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ], [
            'item_id.required' => 'Pilih minimal satu sarana prasarana yang akan dipinjam.',
            'item_id.min' => 'Pilih minimal satu sarana prasarana yang akan dipinjam.',
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam minimal hari ini.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus sama atau setelah tanggal pinjam.',
            'keperluan.min' => 'Jelaskan keperluan peminjaman minimal 10 karakter.',
        ]);

        // Gabungkan jika ada barang yang sama dipilih lebih dari 1 kali
        $aggregatedItems = [];
        foreach ($request->item_id as $index => $itemId) {
            if (!$itemId) continue;
            $qty = (int) ($request->jumlah[$index] ?? 1);
            if ($qty < 1) $qty = 1;

            if (!isset($aggregatedItems[$itemId])) {
                $aggregatedItems[$itemId] = 0;
            }
            $aggregatedItems[$itemId] += $qty;
        }

        if (empty($aggregatedItems)) {
            return back()->withInput()->withErrors(['item_id' => 'Pilih minimal satu sarana prasarana yang akan dipinjam.']);
        }

        // Cek ketersediaan stok
        foreach ($aggregatedItems as $itemId => $totalQty) {
            $item = Item::findOrFail($itemId);
            if ($item->stok_tersedia < $totalQty) {
                return back()->withInput()->withErrors([
                    'item_id' => "Stok sarana prasarana '{$item->nama_barang}' tidak mencukupi (Tersedia: {$item->stok_tersedia}, Diminta: {$totalQty}).",
                ]);
            }
        }

        DB::beginTransaction();
        try {
            // Generate Kode Transaksi unik: JTI-YYMM-RAND
            $kodeTransaksi = 'JTI-' . date('Ym') . '-' . strtoupper(Str::random(5));

            $borrowingData = [
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => Auth::id(),
                'nama_peminjam' => $validated['nama_peminjam'],
                'nim_nip' => $validated['nim_nip'],
                'prodi' => $validated['prodi'],
                'no_hp' => $validated['no_hp'],
                'email' => Auth::user()?->email,
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'keperluan' => $validated['keperluan'],
                'status' => 'menunggu',
            ];

            if (Schema::hasColumn('borrowings', 'lokasi_penggunaan')) {
                $borrowingData['lokasi_penggunaan'] = $validated['lokasi_penggunaan'] ?? null;
            }

            $jamMulai = $request->input('jam_mulai', '07:00');
            $jamSelesai = ($request->filled('sampai_selesai') || empty($request->input('jam_selesai')) || strtolower(trim((string)$request->input('jam_selesai'))) === 'selesai')
                ? 'selesai'
                : $request->input('jam_selesai');

            if (Schema::hasColumn('borrowings', 'jam_mulai')) {
                $borrowingData['jam_mulai'] = $jamMulai;
            }
            if (Schema::hasColumn('borrowings', 'jam_selesai')) {
                $borrowingData['jam_selesai'] = $jamSelesai;
            }

            $borrowing = Borrowing::create($borrowingData);

            foreach ($aggregatedItems as $itemId => $qty) {
                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'item_id' => $itemId,
                    'jumlah' => $qty,
                ]);
            }

            DB::commit();

            return redirect()->route('peminjaman.show', $borrowing->id)
                ->with('success', "Pengajuan peminjaman berhasil dibuat dengan Kode: {$kodeTransaksi}. Silakan simpan kode ini atau cetak surat peminjaman.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal membuat pengajuan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['details.item.category', 'user'])->findOrFail($id);

        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Tampilan Resmi Template Surat Peminjaman Barang JTI (Printable)
     */
    public function surat($id)
    {
        $borrowing = Borrowing::with(['details.item.category'])->findOrFail($id);

        return view('borrowings.surat', compact('borrowing'));
    }

    /**
     * Halaman Cek Resi / Tracking Status Peminjaman Publik
     */
    public function tracking(Request $request)
    {
        $borrowing = null;
        if ($request->filled('kode')) {
            $borrowing = Borrowing::with('details.item.category')
                ->where('kode_transaksi', trim($request->kode))
                ->orWhere('nim_nip', trim($request->kode))
                ->latest()
                ->first();
        }

        return view('borrowings.tracking', compact('borrowing'));
    }
}

