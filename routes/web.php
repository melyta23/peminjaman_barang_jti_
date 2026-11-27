<?php

use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Public Routes (Mahasiswa / Tamu)
Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/katalog', [ItemController::class, 'index'])->name('katalog');

// API Dependent Dropdown Barang per Kategori
Route::get('/api/kategori/{id}/items', [ItemController::class, 'getByCategory'])->name('api.items.by_category');

// API Cek Status Admin Online / Offline (Realtime)
Route::get('/api/server-status', function () {
    $lastActive = \Illuminate\Support\Facades\Cache::get('admin_last_active');
    $isAdminOnline = $lastActive && (now()->timestamp - (int) $lastActive) <= 10;

    return response()->json([
        'status' => $isAdminOnline ? 'online' : 'offline',
        'admin_online' => $isAdminOnline,
    ]);
})->name('api.server_status');

Route::middleware(['auth', 'admin'])->post('/api/admin-heartbeat', function () {
    \Illuminate\Support\Facades\Cache::put('admin_last_active', now()->timestamp, 12);
    return response()->json(['status' => 'online']);
})->name('api.admin_heartbeat');

// Form & Pengajuan Peminjaman
Route::get('/peminjaman', function () {
    return redirect()->route('peminjaman.create');
})->name('peminjaman.index');
Route::get('/peminjaman/ajukan', [BorrowingController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [BorrowingController::class, 'store'])->name('peminjaman.store');
Route::get('/peminjaman/{id}', [BorrowingController::class, 'show'])->name('peminjaman.show');
Route::get('/peminjaman/{id}/surat', [BorrowingController::class, 'surat'])->name('peminjaman.surat');
Route::get('/tracking', [BorrowingController::class, 'tracking'])->name('peminjaman.tracking');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Panel Khusus Admin / Laboran
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Peminjaman
    Route::get('/peminjaman', [AdminBorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/peminjaman/{id}', [AdminBorrowingController::class, 'show'])->name('borrowings.show');
    Route::put('/peminjaman/{id}/status', [AdminBorrowingController::class, 'updateStatus'])->name('borrowings.update_status');

    // Manajemen Barang
    Route::resource('items', AdminItemController::class);
});
