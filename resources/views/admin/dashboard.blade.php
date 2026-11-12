@extends('layouts.admin')

@section('title', 'Dashboard Kontrol Laboran')
@section('page_title', 'Dashboard & Pusat Kontrol Laboran')

@section('content')

    <!-- 1. HERO METRIC CARDS (4 KARTU MODERN & INTERAKTIF) -->
    <div class="row g-3 mb-4">
        <!-- Metrik 1: Total Unit -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Total Aset Sarpras</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalItems }} <span class="fs-6 fw-normal text-muted">Unit</span></h2>
                    </div>
                    <div class="metric-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-boxes"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 small text-muted mt-2">
                    <span class="badge bg-light text-dark border py-0.5 px-1.5 fw-normal">3 Laboratorium</span>
                    <span>Terdaftar di sistem</span>
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Metrik 2: Siap Pakai -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Stok Siap Digunakan</span>
                        <h2 class="fw-bold text-success mt-1 mb-0">{{ $tersediaItems }} <span class="fs-6 fw-normal text-muted">Unit</span></h2>
                    </div>
                    <div class="metric-icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 small mt-2">
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold py-0.5 px-2">{{ $persenTersedia }}% Ready</span>
                    <span class="text-muted">Siap dipinjam</span>
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-success" style="width: {{ $persenTersedia }}%"></div>
                </div>
            </div>
        </div>

        <!-- Metrik 3: Sedang Dipinjam -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Sedang Dipinjam</span>
                        <h2 class="fw-bold text-warning mt-1 mb-0" style="color: #d97706 !important;">{{ $dipinjamItems }} <span class="fs-6 fw-normal text-muted">Unit</span></h2>
                    </div>
                    <div class="metric-icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-arrow-left-right text-warning" style="color: #d97706 !important;"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 small mt-2">
                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold py-0.5 px-2" style="color: #d97706 !important;">{{ $persenDipinjam }}% Aktif</span>
                    <span class="text-muted">Di luar laboratorium</span>
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-warning" style="width: {{ $persenDipinjam }}%; background-color: #d97706 !important;"></div>
                </div>
            </div>
        </div>

        <!-- Metrik 4: Menunggu Persetujuan -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden border-danger border-opacity-25" style="background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-danger small fw-semibold text-uppercase tracking-wider">Perlu Verifikasi</span>
                        <h2 class="fw-bold text-danger mt-1 mb-0">{{ $pendingBorrowings }} <span class="fs-6 fw-normal text-muted">Surat</span></h2>
                    </div>
                    <div class="metric-icon-box bg-danger bg-opacity-10 text-danger position-relative">
                        <i class="bi bi-bell-fill"></i>
                        @if($pendingBorrowings > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-1.5 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 small mt-2">
                    @if($pendingBorrowings > 0)
                        <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle-fill me-1"></i> Tindakan segera</span>
                    @else
                        <span class="text-success"><i class="bi bi-check2-circle me-1"></i> Semua tuntas</span>
                    @endif
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-danger" style="width: {{ $pendingBorrowings > 0 ? '100' : '0' }}%"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- 2. VISUAL ANALYTICS ROW (GRAFIK CHART.JS MODERN) -->
    <div class="row g-3 mb-4">
        <!-- Grafik 1: Tren Peminjaman Mingguan (Area Chart) -->
        <div class="col-lg-8">
            <div class="card card-ui p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Tren Aktivitas Peminjaman Sarpras</h6>
                        <span class="text-muted small">Frekuensi peminjaman alat 7 hari operasional terakhir</span>
                    </div>
                    <span class="badge bg-light text-primary border small fw-semibold">
                        <i class="bi bi-graph-up-arrow me-1"></i> Data Real-Time
                    </span>
                </div>
                <div style="height: 240px; position: relative;">
                    <canvas id="borrowTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik 2: Komposisi Kategori (Doughnut Chart) -->
        <div class="col-lg-4">
            <div class="card card-ui p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Distribusi 3 Kategori</h6>
                        <span class="text-muted small">Porsi ketersediaan inventaris</span>
                    </div>
                </div>
                <div style="height: 180px; position: relative;" class="my-auto">
                    <canvas id="categoryDonutChart"></canvas>
                </div>
                <div class="d-flex justify-content-around text-center border-top pt-3 mt-2 small text-muted">
                    <div>
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #4f46e5;"></span>
                        <div>Musik (4)</div>
                    </div>
                    <div>
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #d97706;"></span>
                        <div>Syuting (5)</div>
                    </div>
                    <div>
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #0284c7;"></span>
                        <div>PC (4)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 3. TABEL PENGAJUAN & STATUS LAB -->
    <div class="row g-3 mb-4">
        <!-- Tabel Pengajuan Real-Time (8 Kolom) -->
        <div class="col-lg-8">
            <div class="card card-ui h-100 overflow-hidden">
                <div class="p-4 border-bottom bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-text-fill text-primary"></i> Permohonan Peminjaman Masuk
                        </h5>
                        <span class="text-muted small">Daftar mahasiswa yang mengajukan sarpras & siap diverifikasi</span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary btn-sm px-3 fw-semibold">
                            Lihat Semua
                        </a>
                        <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Sarpras
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                        <thead class="table-light text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-4 py-3">Peminjam</th>
                                <th>Sarana Prasarana</th>
                                <th>Durasi Pinjam</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $b)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($b->nama_peminjam, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $b->nama_peminjam }}</div>
                                                <div class="text-muted" style="font-size: 0.76rem;">
                                                    <code>{{ $b->kode_transaksi }}</code> • {{ $b->nim_nip }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($b->details as $d)
                                            <div>
                                                <span class="badge bg-light text-dark border small fw-normal">
                                                    {{ $d->item->nama_barang }} ({{ $d->jumlah }} unit)
                                                </span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="small">
                                        <div>{{ $b->tanggal_pinjam->format('d/m/Y') }}</div>
                                        <div class="text-danger fw-semibold" style="font-size: 0.78rem;">s/d {{ $b->tanggal_kembali->format('d/m/Y') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $b->status_badge }} small">
                                            {{ $b->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.borrowings.show', $b->id) }}" class="btn btn-primary shadow-sm" title="Kelola & Verifikasi">
                                                Verifikasi
                                            </a>
                                            <a href="{{ route('peminjaman.surat', $b->id) }}" target="_blank" class="btn btn-outline-secondary" title="Cetak Surat Polije">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                        Belum ada permohonan peminjaman yang masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Kesiapan 3 Laboratorium & SOP (4 Kolom) -->
        <div class="col-lg-4">
            
            <!-- Kesiapan 3 Lab -->
            <div class="card card-ui p-4 mb-3">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-building-check text-primary"></i> Kesiapan Inventaris 3 Lab
                </h6>

                <div class="d-flex flex-column gap-3">
                    @foreach($categories as $c)
                        @php
                            $cTotal = $c->items->sum('stok_total') ?: 1;
                            $cReady = $c->items->sum('stok_tersedia') ?: 0;
                            $cPercent = round(($cReady / $cTotal) * 100);
                            $cTheme = match($c->slug) {
                                'alat-musik' => ['color' => '#4f46e5', 'icon' => 'bi-music-note-beamed'],
                                'alat-syuting' => ['color' => '#d97706', 'icon' => 'bi-camera-video-fill'],
                                'pc' => ['color' => '#0284c7', 'icon' => 'bi-pc-display'],
                                default => ['color' => '#1e3a8a', 'icon' => 'bi-box-seam'],
                            };
                        @endphp
                        <div class="p-3 rounded-3 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark small d-flex align-items-center gap-1.5">
                                    <i class="bi {{ $cTheme['icon'] }}" style="color: {{ $cTheme['color'] }};"></i>
                                    {{ $c->nama }}
                                </span>
                                <span class="badge small" style="background: {{ $cTheme['color'] }}; color: #ffffff;">{{ $cReady }} / {{ $cTotal }} Unit</span>
                            </div>
                            <div class="text-muted small mb-2" style="font-size: 0.76rem;">
                                {{ $c->items_count }} jenis inventaris terdata
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" style="width: {{ $cPercent }}%; background-color: {{ $cTheme['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Petunjuk SOP Singkat -->
            <div class="card card-ui p-4 bg-light border">
                <h6 class="fw-bold text-dark mb-2 small d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-primary"></i> Prosedur Verifikasi Laboran
                </h6>
                <ol class="small text-secondary ps-3 mb-0" style="line-height: 1.55;">
                    <li>Periksa kelayakan barang sebelum diserahkan.</li>
                    <li>Wajib meminta lembar <strong>Surat BEM Polije</strong> bertandatangan.</li>
                    <li>Ubah status menjadi <strong>Disetujui</strong> saat barang diambil mahasiswa.</li>
                    <li>Ubah status menjadi <strong>Selesai</strong> saat barang dikembalikan lengkap.</li>
                </ol>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Chart Tren Peminjaman (Area Chart)
    const ctxTrend = document.getElementById('borrowTrendChart').getContext('2d');
    const gradient = ctxTrend.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Frekuensi Peminjaman',
                data: [3, 5, 2, 6, 8, 4, 3],
                borderColor: '#2563eb',
                borderWidth: 2.5,
                backgroundColor: gradient,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#091322',
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 2, font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
                }
            }
        }
    });

    // 2. Chart Komposisi Kategori (Doughnut Chart)
    const ctxDonut = document.getElementById('categoryDonutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: ['Alat Musik', 'Alat Syuting', 'PC & Lab'],
            datasets: [{
                data: [4, 5, 4],
                backgroundColor: ['#4f46e5', '#d97706', '#0284c7'],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#091322',
                    padding: 8,
                    cornerRadius: 6
                }
            }
        }
    });
});
</script>
@endpush
