@extends('layouts.app')

@section('title', 'Data Peminjaman Barang - Admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Daftar Peminjaman Barang</h3>
            <p class="text-muted small mb-0">Pantau dan verifikasi seluruh pengajuan peminjaman barang laboratorium JTI</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <!-- Filter Peminjaman -->
    <div class="card p-3 mb-4">
        <form method="GET" action="{{ route('admin.borrowings.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari Kode Transaksi, Nama, atau NIM...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui / Sedang Dipinjam</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control" placeholder="Tanggal Pinjam" onchange="this.form.submit()">
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request()->hasAny(['q', 'status', 'tanggal']))
                    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Peminjaman -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Peminjam</th>
                            <th>Barang yang Dipinjam</th>
                            <th>Jadwal Pinjam</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowings as $idx => $b)
                            <tr>
                                <td>{{ $borrowings->firstItem() + $idx }}</td>
                                <td><code>{{ $b->kode_transaksi }}</code></td>
                                <td>
                                    <strong>{{ $b->nama_peminjam }}</strong><br>
                                    <span class="small text-muted">{{ $b->nim_nip }} - {{ $b->prodi }}</span>
                                </td>
                                <td>
                                    @foreach($b->details as $d)
                                        <div>
                                            <span class="badge bg-light text-dark border">{{ $d->item->nama_barang }} ({{ $d->jumlah }} unit)</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="small">
                                    Mulai: <strong>{{ $b->tanggal_pinjam->format('d M Y') }}</strong><br>
                                    Kembali: <strong class="text-danger">{{ $b->tanggal_kembali->format('d M Y') }}</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $b->status_badge }}">{{ $b->status_label }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.borrowings.show', $b->id) }}" class="btn btn-primary" title="Detail & Verifikasi">
                                            <i class="bi bi-pencil-square me-1"></i> Kelola
                                        </a>
                                        <a href="{{ route('peminjaman.surat', $b->id) }}" target="_blank" class="btn btn-outline-secondary" title="Cetak Surat">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Tidak ada data peminjaman barang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $borrowings->links() }}
    </div>
</div>
@endsection

