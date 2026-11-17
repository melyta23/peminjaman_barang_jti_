@extends('layouts.app')

@section('title', 'Detail Peminjaman ' . $borrowing->kode_transaksi)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Navigasi -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('peminjaman.surat', $borrowing->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-printer me-1"></i> Cetak Surat Peminjaman
                    </a>
                </div>
            </div>

            <!-- Kartu Status Utama -->
            <div class="card card-premium shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-4 gap-2">
                        <div>
                            <span class="text-muted small">Kode Registrasi Peminjaman:</span>
                            <div class="d-flex align-items-center gap-2">
                                <h3 class="fw-bold text-dark mb-0 font-monospace">{{ $borrowing->kode_transaksi }}</h3>
                                <button class="btn btn-outline-secondary btn-sm py-0.5 px-2" onclick="navigator.clipboard.writeText('{{ $borrowing->kode_transaksi }}'); alert('Kode berhasil disalin!');" title="Salin Kode">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                            <span class="text-muted small">Diajukan pada: {{ $borrowing->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>
                        <div class="text-md-end">
                            <span class="text-muted small d-block mb-1">Status Pengajuan:</span>
                            <span class="badge {{ $borrowing->status_badge }} fs-6 px-3 py-2">
                                {{ $borrowing->status_label }}
                            </span>
                        </div>
                    </div>

                    @if($borrowing->status === 'menunggu')
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-hourglass-split fs-4 me-3"></i>
                            <div>
                                <strong>Pengajuan Sedang Menunggu Verifikasi Admin/Laboran JTI.</strong><br>
                                Silakan cetak template surat peminjaman di bawah ini dan mintakan tanda tangan kepada penanggung jawab / dosen pembimbing sebelum mengambil barang di laboratorium.
                            </div>
                        </div>
                    @elseif($borrowing->status === 'disetujui')
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Peminjaman Telah Disetujui!</strong><br>
                                Barang telah dicatat dipinjam. Harap mengembalikan barang paling lambat pada tanggal <strong>{{ $borrowing->tanggal_kembali->translatedFormat('d F Y') }}</strong> dalam kondisi baik.
                            </div>
                        </div>
                    @elseif($borrowing->status === 'ditolak')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Pengajuan Peminjaman Ditolak.</strong><br>
                                Catatan Admin: {{ $borrowing->catatan_admin ?? 'Tidak ada catatan khusus.' }}
                            </div>
                        </div>
                    @elseif($borrowing->status === 'selesai')
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-shield-check fs-4 me-3"></i>
                            <div>
                                <strong>Barang Telah Selesai Dikembalikan.</strong><br>
                                Tanggal Pengembalian: {{ $borrowing->tanggal_pengembalian_aktual?->translatedFormat('d F Y') ?? '-' }}. Terima kasih telah merawat inventaris lab JTI.
                            </div>
                        </div>
                    @endif

                    <!-- Detail Peminjam & Waktu -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100 border">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                                    <i class="bi bi-person me-1"></i> Data Peminjam
                                </h6>
                                <table class="table table-sm table-borderless mb-0 small" style="table-layout: fixed; width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted py-1" style="width: 130px; white-space: nowrap; vertical-align: top;">Nama</td>
                                            <td class="text-muted py-1 px-0" style="width: 15px; text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                <strong>{{ $borrowing->nama_peminjam }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">NIM / NIP</td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                {{ $borrowing->nim_nip }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">Program Studi</td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                {{ $borrowing->prodi }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">No. WhatsApp</td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
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
                                                    <a href="whatsapp://send?phone={{ $cleanPhone }}" class="text-decoration-none text-success fw-semibold" title="Buka Chat di Aplikasi WhatsApp">
                                                        <i class="bi bi-whatsapp me-1"></i>{{ $borrowing->no_hp }}
                                                    </a>
                                                @else
                                                    <span>{{ $borrowing->no_hp ?? '-' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100 border">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                                    <i class="bi bi-calendar3 me-1"></i> Waktu & Keperluan
                                </h6>
                                <table class="table table-sm table-borderless mb-0 small" style="table-layout: fixed; width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted py-1" style="width: 130px; white-space: nowrap; vertical-align: top;">Tanggal Pinjam</td>
                                            <td class="text-muted py-1 px-0" style="width: 15px; text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                <strong>{{ $borrowing->tanggal_pinjam->translatedFormat('d F Y') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">Jam / Waktu</td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                <strong>{{ $borrowing->rentang_waktu }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">Estimasi Kembali</td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                <strong class="text-danger">{{ $borrowing->tanggal_kembali->translatedFormat('d F Y') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">Keperluan</td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 text-dark" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                {{ $borrowing->keperluan }}
                                            </td>
                                        </tr>
                                        @if($borrowing->lokasi_penggunaan)
                                        <tr>
                                            <td class="text-muted py-1" style="white-space: nowrap; vertical-align: top;">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>Lokasi Penggunaan
                                            </td>
                                            <td class="text-muted py-1 px-0" style="text-align: center; vertical-align: top;">:</td>
                                            <td class="py-1 fw-semibold text-danger-emphasis" style="word-break: break-word; overflow-wrap: anywhere; vertical-align: top;">
                                                {{ $borrowing->lokasi_penggunaan }}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Barang yang Dipinjam -->
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-box-seam me-1"></i> Daftar Barang yang Dipinjam
                    </h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Kondisi Saat Ini</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowing->details as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><code>{{ $detail->item->kode_barang }}</code></td>
                                        <td class="fw-semibold">{{ $detail->item->nama_barang }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $detail->item->category->nama }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $detail->item->kondisi == 'Baik' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $detail->item->kondisi }}
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">{{ $detail->jumlah }} unit</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Aksi Surat Peminjaman -->
                    <div class="card bg-light border p-4 text-center rounded-3">
                        <div class="d-inline-flex p-3 bg-white text-primary rounded-circle shadow-sm mx-auto mb-2">
                            <i class="bi bi-file-earmark-pdf-fill fs-2 text-danger"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Cetak Dokumen Surat Permohonan BEM KM Polije</h5>
                        <p class="text-muted small mb-3" style="max-width: 520px; margin: 0 auto;">
                            Dokumen resmi 2 halaman (Surat Permohonan Izin & Lampiran Sarana Prasarana) dengan Kop Surat Politeknik Negeri Jember dan stempel autentik.
                        </p>
                        <div>
                            <a href="{{ route('peminjaman.surat', $borrowing->id) }}" target="_blank" class="btn btn-polije-primary btn-lg px-4 shadow-sm">
                                <i class="bi bi-printer-fill me-2"></i> Buka & Cetak Surat Resmi (A4 Ready)
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

