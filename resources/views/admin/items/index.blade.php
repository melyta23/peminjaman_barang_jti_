@extends('layouts.admin')

@section('title', 'Kelola Inventaris Sarpras - Admin SIPEMBAR JTI')
@section('page_title', 'Inventaris Sarpras Laboratorium')

@section('content')
<div class="pb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Manajemen Inventaris Barang</h3>
            <p class="text-muted small mb-0">Kelola stok, data, dan kondisi barang Alat Musik, Alat Syuting, dan PC</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Barang Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card p-3 mb-4">
        <form method="GET" action="{{ route('admin.items.index') }}" class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama barang, merk, atau kode...">
            </div>
            <div class="col-md-4">
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                @if(request()->hasAny(['q', 'category_id']))
                    <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Barang -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Kode</th>
                            <th>Nama Barang & Merk</th>
                            <th>Kategori</th>
                            <th>Stok (Tersedia / Total)</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $idx => $item)
                            <tr>
                                <td>{{ $items->firstItem() + $idx }}</td>
                                <td><code>{{ $item->kode_barang }}</code></td>
                                <td>
                                    <strong>{{ $item->nama_barang }}</strong><br>
                                    <span class="small text-muted">{{ $item->merk ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->category->nama }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $item->stok_tersedia > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $item->stok_tersedia }}
                                    </span> 
                                    / {{ $item->stok_total }} unit
                                    @php
                                        $unitDipinjam = $item->stok_total - $item->stok_tersedia;
                                    @endphp
                                    @if($unitDipinjam > 0)
                                        <div class="small text-danger mt-1">
                                            <i class="bi bi-arrow-right-circle me-1"></i>{{ $unitDipinjam }} unit dipinjam
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->kondisi == 'Baik' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $item->kondisi }}
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $item->lokasi_penyimpanan ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit Barang">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus Barang">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    Belum ada data barang di inventaris.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $items->links() }}
    </div>
</div>
@endsection

