<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
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
        $rejectedBorrowings = Borrowing::where('status', 'ditolak')->count();

        // 10 Pengajuan terbaru dengan relasi item dan kategori
        $recentBorrowings = Borrowing::with(['details.item.category', 'user'])->latest()->take(10)->get();

        // Data kategori dengan relasi inventaris
        $categories = Category::with(['items'])->withCount('items')->get();

        $persenTersedia = $totalItems > 0 ? round(($tersediaItems / $totalItems) * 100) : 100;
        $persenDipinjam = $totalItems > 0 ? round(($dipinjamItems / $totalItems) * 100) : 0;

        // Data Real Grafik Tren 7 Hari Terakhir
        $trendLabels = [];
        $trendValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $trendLabels[] = $date->translatedFormat('D, d M');
            $trendValues[] = Borrowing::whereDate('tanggal_pinjam', $date->toDateString())->count();
        }

        // Data Real Donut Distribusi Kategori
        $categoryDonutLabels = [];
        $categoryDonutData = [];
        foreach ($categories as $cat) {
            $categoryDonutLabels[] = $cat->nama;
            $categoryDonutData[] = $cat->items->sum('stok_total') ?: 0;
        }

        return view('admin.dashboard', compact(
            'totalItems',
            'tersediaItems',
            'dipinjamItems',
            'totalBorrowings',
            'pendingBorrowings',
            'activeBorrowings',
            'completedBorrowings',
            'rejectedBorrowings',
            'recentBorrowings',
            'categories',
            'persenTersedia',
            'persenDipinjam',
            'trendLabels',
            'trendValues',
            'categoryDonutLabels',
            'categoryDonutData'
        ));
    }
}

