<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::sum('stok_total') ?: 0;
        $tersediaItems = Item::sum('stok_tersedia') ?: 0;
        $dipinjamItems = max(0, $totalItems - $tersediaItems);

        $totalBorrowings = Borrowing::count();
        $pendingBorrowings = Borrowing::where('status', 'menunggu')->count();
        $activeBorrowings = Borrowing::where('status', 'disetujui')->count();
        $completedBorrowings = Borrowing::where('status', 'selesai')->count();

        $recentBorrowings = Borrowing::with(['details.item.category'])->latest()->take(8)->get();
        $categories = Category::with(['items'])->withCount('items')->get();

        $persenTersedia = $totalItems > 0 ? round(($tersediaItems / $totalItems) * 100) : 100;
        $persenDipinjam = $totalItems > 0 ? round(($dipinjamItems / $totalItems) * 100) : 0;

        return view('admin.dashboard', compact(
            'totalItems',
            'tersediaItems',
            'dipinjamItems',
            'totalBorrowings',
            'pendingBorrowings',
            'activeBorrowings',
            'completedBorrowings',
            'recentBorrowings',
            'categories',
            'persenTersedia',
            'persenDipinjam'
        ));
    }
}
