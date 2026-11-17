@extends('layouts.admin')

@section('title', 'Data Peminjaman Barang - Admin SIPEMBAR JTI')
@section('page_title', 'Data Peminjaman Barang')

@section('content')
<div class="pb-3">
    <!-- Header Page -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-2.5 py-1 rounded-pill fw-semibold" style="background: rgba(59, 110, 165, 0.12); color: #3b6ea5; border: 1px solid rgba(59, 110, 165, 0.25); font-size: 0.74rem;">
                    <i class="bi bi-shield-check me-1"></i> PANEL ADMINISTRATOR
                </span>
                <span class="text-muted small">• Sirkulasi Sarpras JTI</span>
            </div>
            <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.3px;">Daftar Peminjaman Barang</h3>
            <p class="text-muted small mb-0">Pantau, verifikasi, dan kelola seluruh pengajuan peminjaman barang laboratorium JTI Polije.</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-3 shadow-2xs fw-semibold d-inline-flex align-items-center gap-1.5">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Filter Card Modern -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff; border: 1px solid rgba(0,0,0,0.06) !important;">
        <div class="card-body p-3.5">
            <form method="GET" action="{{ route('admin.borrowings.index') }}" class="row g-2.5 align-items-center">
                <!-- Input Pencarian -->
                <div class="col-lg-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 py-2 ps-2" placeholder="Cari Kode Transaksi, Nama, atau NIM...">
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="col-lg-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <i class="bi bi-funnel"></i>
                        </span>
                        <select name="status" class="form-select border-start-0 py-2 ps-2" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui / Sedang Dipinjam</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Tanggal -->
                <div class="col-lg-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control border-start-0 py-2 ps-2" title="Filter Tanggal Pinjam" onchange="this.form.submit()">
                    </div>
                </div>

                <!-- Tombol Aksi Filter -->
                <div class="col-lg-2 col-md-6 d-flex gap-1.5">
                    <button type="submit" class="btn btn-sm btn-primary w-100 fw-semibold py-2 d-inline-flex align-items-center justify-content-center gap-1 shadow-sm rounded-3">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request()->hasAny(['q', 'status', 'tanggal']))
                        <a href="{{ route('admin.borrowings.index') }}" class="btn btn-sm btn-outline-secondary py-2 px-2.5 rounded-3" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Peminjaman -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid rgba(0,0,0,0.06) !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th class="ps-3.5 py-3 text-secondary text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px; width: 50px;">No</th>
                            <th class="py-3 text-secondary text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Kode Transaksi</th>
                            <th class="py-3 text-secondary text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Peminjam / Mahasiswa</th>
                            <th class="py-3 text-secondary text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Barang yang Dipinjam</th>
                            <th class="py-3 text-secondary text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Jadwal Pinjam</th>
                            <th class="py-3 text-secondary text-uppercase fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px;">Status</th>
                            <th class="pe-3.5 py-3 text-secondary text-uppercase fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px; width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($borrowings as $idx => $b)
                            <tr>
                                <!-- No -->
                                <td class="ps-3.5 py-3 text-muted fw-semibold" style="font-size: 0.82rem;">
                                    {{ $borrowings->firstItem() + $idx }}
                                </td>

                                <!-- Kode Transaksi -->
                                <td class="py-3" style="white-space: nowrap;">
                                    <span class="badge bg-light text-primary border border-primary border-opacity-25 font-monospace fw-semibold px-2 py-1 rounded" style="font-size: 0.76rem; letter-spacing: 0.2px;">
                                        {{ $b->kode_transaksi }}
                                    </span>
                                </td>

                                <!-- Peminjam / Mahasiswa -->
                                <td class="py-3">
                                    <div class="d-flex align-items-center" style="gap: 14px;">
                                        <!-- Avatar Lingkaran Profil Soft Blue -->
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs flex-shrink-0" 
                                            style="width: 38px; height: 38px; font-size: 0.82rem; background: linear-gradient(135deg, #4272a8, #2c598a); border: 2px solid #ffffff;">
                                            {{ strtoupper(substr($b->nama_peminjam, 0, 2)) }}
                                        </div>

                                        <!-- Informasi Peminjam -->
                                        <div style="min-width: 0;">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.88rem; line-height: 1.25;" title="{{ $b->nama_peminjam }}">
                                                {{ $b->nama_peminjam }}
                                            </div>
                                            <div class="text-muted mt-0.5" style="font-size: 0.76rem; line-height: 1.3;">
                                                <span class="text-secondary fw-medium">NIM:</span> 
                                                <span class="text-dark fw-semibold">{{ $b->nim_nip }}</span>
                                                @if(!empty($b->prodi))
                                                    <span class="mx-1 text-muted">•</span>
                                                    <span>{{ $b->prodi }}</span>
                                                @endif
                                            </div>

                                            @php
                                                $rawPhone = $b->no_hp ?? '';
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                } elseif (str_starts_with($cleanPhone, '8')) {
                                                    $cleanPhone = '62' . $cleanPhone;
                                                }
                                            @endphp

                                            @if(!empty($cleanPhone) && strlen($cleanPhone) >= 7)
                                                <div class="mt-0.5">
                                                    <a href="whatsapp://send?phone={{ $cleanPhone }}" 
                                                        class="text-success text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" 
                                                        style="font-size: 0.74rem;" 
                                                        title="Buka Chat di Aplikasi WhatsApp ({{ $b->no_hp }})">
                                                        <i class="bi bi-whatsapp"></i>
                                                        <span>{{ $b->no_hp }}</span>
                                                    </a>
                                                </div>
                                            @elseif(!empty($b->no_hp))
                                                <div class="mt-0.5 text-muted d-inline-flex align-items-center gap-1" style="font-size: 0.74rem;">
                                                    <i class="bi bi-telephone text-secondary"></i>
                                                    <span>{{ $b->no_hp }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Barang yang Dipinjam (Multi-item Support) -->
                                <td class="py-3">
                                    <div class="d-flex flex-column gap-1">
                                        @foreach($b->details as $d)
                                            <div>
                                                <span class="badge bg-white text-dark border py-1.5 px-2 rounded-2 shadow-2xs d-inline-flex align-items-center gap-1" style="font-size: 0.76rem; font-weight: 500;">
                                                    <i class="bi bi-box-seam text-secondary"></i>
                                                    <strong>{{ $d->item->nama_barang }}</strong>
                                                    <span class="text-primary fw-bold ms-1">({{ $d->jumlah }} unit)</span>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Jadwal Pinjam -->
                                <td class="py-3 small" style="white-space: nowrap;">
                                    <div class="fw-semibold text-dark d-flex align-items-center gap-1">
                                        <i class="bi bi-calendar-event text-secondary"></i>
                                        <span>{{ $b->tanggal_pinjam->format('d M Y') }}</span>
                                        <span class="text-muted font-monospace fw-normal">s/d</span>
                                        <span class="text-danger fw-bold">{{ $b->tanggal_kembali->format('d M Y') }}</span>
                                    </div>
                                    <div class="text-muted mt-0.5 d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock text-primary"></i>
                                        <span>{{ $b->rentang_waktu }}</span>
                                    </div>
                                    @if(!empty($b->lokasi_penggunaan))
                                    <div class="mt-1 d-flex align-items-center gap-1" style="font-size: 0.74rem; white-space: normal; max-width: 200px;">
                                        <i class="bi bi-geo-alt-fill text-danger flex-shrink-0"></i>
                                        <span class="fw-semibold text-danger-emphasis">{{ $b->lokasi_penggunaan }}</span>
                                    </div>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="py-3 text-center" style="white-space: nowrap;">
                                    <span class="badge {{ $b->status_badge }} px-2.5 py-1.5 rounded-pill fw-semibold shadow-2xs" style="font-size: 0.75rem;">
                                        {{ $b->status_label }}
                                    </span>
                                </td>

                                <!-- Aksi Cepat -->
                                <td class="pe-3.5 py-3 text-center" style="white-space: nowrap;">
                                    <div class="btn-group btn-group-sm shadow-2xs">
                                        <a href="{{ route('admin.borrowings.show', $b->id) }}" class="btn btn-primary px-2.5 fw-semibold" title="Kelola & Verifikasi">
                                            <i class="bi bi-pencil-square me-1"></i> Kelola
                                        </a>
                                        <a href="{{ route('peminjaman.surat', $b->id) }}" target="_blank" class="btn btn-outline-secondary px-2" title="Cetak Surat Polije">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        <div class="fw-semibold text-dark fs-6 mb-1">Tidak Ada Data Peminjaman</div>
                                        <p class="text-muted small mb-0">Belum ada pengajuan peminjaman barang atau tidak cocok dengan filter pencarian.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($borrowings->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $borrowings->links() }}
        </div>
    @endif
</div>
@endsection
