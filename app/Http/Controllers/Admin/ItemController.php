<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Item::with('category')->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->q . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->q . '%');
            });
        }

        $items = $query->paginate(15)->withQueryString();

        return view('admin.items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'kode_barang' => 'required|string|unique:items,kode_barang|max:50',
            'nama_barang' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['stok_tersedia'] = $validated['stok_total'];

        Item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Barang baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();

        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'kode_barang' => 'required|string|max:50|unique:items,kode_barang,' . $item->id,
            'nama_barang' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'stok_total' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0|lte:stok_total',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        // Jangan hapus jika sedang ada peminjaman aktif
        $activeBorrowings = $item->borrowingDetails()
            ->whereHas('borrowing', function ($q) {
                $q->whereIn('status', ['menunggu', 'disetujui']);
            })->exists();

        if ($activeBorrowings) {
            return back()->with('error', 'Barang tidak dapat dihapus karena masih terkait dengan peminjaman aktif/menunggu.');
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil dihapus.');
    }
}

