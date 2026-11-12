<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // Hanya muat 3 kategori utama beserta relasi barang-barangnya
        $categories = Category::with(['items' => function ($query) {
            $query->orderBy('nama_barang', 'asc');
        }])->get();

        return view('items.index', compact('categories'));
    }

    /**
     * Endpoint API JSON untuk Dropdown Barang per Kategori
     */
    public function getByCategory($categoryId)
    {
        $items = Item::where('category_id', $categoryId)
            ->select('id', 'kode_barang', 'nama_barang', 'merk', 'stok_total', 'stok_tersedia', 'kondisi', 'lokasi_penyimpanan', 'deskripsi')
            ->orderBy('nama_barang', 'asc')
            ->get();

        return response()->json($items);
    }
}
