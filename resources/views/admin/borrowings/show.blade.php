@extends('layouts.admin')

@section('title', 'Verifikasi Peminjaman ' . $borrowing->kode_transaksi)
@section('page_title', 'Verifikasi & Kelola Peminjaman')

@section('content')
<div class="pb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Verifikasi & Pengelolaan Peminjaman</h3>
            <p class="text-muted small mb-0">Kode Transaksi: <code>{{ $borrowing->kode_transaksi }}</code></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            <a href="{{ route('peminjaman.surat', $borrowing->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak Surat Resmi
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Rincian Peminjam & Barang -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i> Rincian Pengajuan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Nama Lengkap:</span>
                            <div class="fw-bold fs-6">{{ $borrowing->nama_peminjam }}</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">NIM / NIP:</span>
                            <div class="fw-bold">{{ $borrowing->nim_nip }}</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Program Studi / Unit:</span>
                            <div>{{ $borrowing->prodi }}</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">No. WhatsApp / HP:</span>
                            <div>
                                @php
                                    $rawPhone = $borrowing->no_hp ?? '';
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    } elseif (str_starts_with($cleanPhone, '8')) {
                                        $cleanPhone = '62' . $cleanPhone;
                                    }
                                @endphp
                                @if(!empty($cleanPhone) && strlen($cleanPhone) >= 9)
                                    <a href="whatsapp://send?phone={{ $cleanPhone }}" class="text-success fw-bold text-decoration-none" title="Buka Chat di Aplikasi WhatsApp">
                                        <i class="bi bi-whatsapp me-1"></i> {{ $borrowing->no_hp }}
                                    </a>
                                @else
                                    <span class="text-dark">{{ $borrowing->no_hp ?? '-' }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Tanggal Mulai Pinjam:</span>
                            <div class="fw-bold text-primary">{{ $borrowing->tanggal_pinjam->translatedFormat('d F Y') }}</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Jam / Waktu Kegiatan:</span>
                            <div class="fw-bold text-dark">{{ $borrowing->rentang_waktu }}</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Estimasi Pengembalian:</span>
                            <div class="fw-bold text-danger">{{ $borrowing->tanggal_kembali->translatedFormat('d F Y') }}</div>
                        </div>
                        <div class="col-12">
                            <span class="text-muted small d-block">Alasan / Keperluan Peminjaman:</span>
                            <div class="p-2 bg-light rounded border mt-1">{{ $borrowing->keperluan }}</div>
                        </div>
                        @if($borrowing->lokasi_penggunaan)
                        <div class="col-12">
                            <span class="text-muted small d-block">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>Lokasi / Tempat Penggunaan Barang:
                            </span>
                            <div class="p-2 mt-1 d-flex align-items-center gap-2 rounded border"
                                style="background: rgba(239,68,68,0.06); border-color: rgba(239,68,68,0.25) !important;">
                                <i class="bi bi-pin-map-fill text-danger"></i>
                                <span class="fw-semibold text-danger-emphasis">{{ $borrowing->lokasi_penggunaan }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <h6 class="fw-bold border-top pt-3 mb-3">Daftar Barang yang Diminta:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok Tersedia Saat Ini</th>
                                    <th class="text-center">Jumlah Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowing->details as $d)
                                    <tr>
                                        <td><code>{{ $d->item->kode_barang }}</code></td>
                                        <td class="fw-semibold">{{ $d->item->nama_barang }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $d->item->category->nama }}</span></td>
                                        <td>
                                            <span class="badge {{ $d->item->stok_tersedia >= $d->jumlah ? 'bg-success' : 'bg-danger' }}">
                                                {{ $d->item->stok_tersedia }} unit tersedia
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">{{ $d->jumlah }} unit</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Ubah Status -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 border-top border-primary border-3 sticky-top" style="top: 80px;">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-shield-check text-success me-1"></i> Kelola Status Peminjaman</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 text-center p-3 bg-light rounded border">
                        <span class="text-muted small d-block mb-1">Status Saat Ini:</span>
                        <span class="badge {{ $borrowing->status_badge }} fs-6 px-3 py-2">
                            {{ $borrowing->status_label }}
                        </span>
                        @if($borrowing->tanggal_pengembalian_aktual)
                            <div class="text-success small mt-2">
                                <i class="bi bi-check-all"></i> Dikembalikan pada: {{ $borrowing->tanggal_pengembalian_aktual->format('d/m/Y') }}
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.borrowings.update_status', $borrowing->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold small">Ubah Status Menjadi:</label>
                            <select name="status" id="status" class="form-select fw-semibold" required>
                                <option value="menunggu" {{ $borrowing->status === 'menunggu' ? 'selected' : '' }}>1. Menunggu Konfirmasi</option>
                                <option value="disetujui" {{ $borrowing->status === 'disetujui' ? 'selected' : '' }}>2. Disetujui (Barang Diambil/Dipinjam)</option>
                                <option value="selesai" {{ $borrowing->status === 'selesai' ? 'selected' : '' }}>3. Selesai (Barang Sudah Dikembalikan)</option>
                                <option value="ditolak" {{ $borrowing->status === 'ditolak' ? 'selected' : '' }}>4. Ditolak (Tidak Memenuhi Syarat)</option>
                            </select>
                            <div class="form-text small">
                                *Ketika disetujui, stok barang otomatis berkurang.<br>
                                *Ketika selesai dikembalikan, stok barang otomatis bertambah kembali.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label fw-bold small">Catatan Admin / Laboran:</label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-control" placeholder="Contoh: Barang diambil jam 13.00, kondisi lengkap...">{{ old('catatan_admin', $borrowing->catatan_admin) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Perbarui Status Peminjaman
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

