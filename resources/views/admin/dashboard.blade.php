@extends('layouts.admin')

@section('title', 'Pusat Kontrol Laboran')
@section('page_title', 'Dashboard & Pusat Kontrol')

@section('content')

    <!-- ======================================================== -->
    <!-- 1. EXECUTIVE WELCOME BANNER (DESAIN MODERN & MEWAH)       -->
    <!-- ======================================================== -->
    <div class="card border-0 mb-4 position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #091322 0%, #0f2347 55%, #1d4ed8 100%); border-radius: 20px;">
        <!-- Subtle Glow Effect -->
        <div class="position-absolute" style="top: -60px; right: -60px; width: 260px; height: 260px; background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
        <div class="position-absolute" style="bottom: -80px; left: 20%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

        <div class="card-body p-4 p-md-4 position-relative z-1">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge px-3 py-1.5 rounded-pill text-white fw-semibold" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.18); font-size: 0.76rem;">
                            <i class="bi bi-shield-check text-warning me-1"></i> SIPEMBAR COMMAND CENTER
                        </span>
                        <span class="badge px-2.5 py-1.5 rounded-pill text-info-emphasis fw-medium small" style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.25); font-size: 0.74rem;">
                            <span class="pulse-online me-1"></span> Live Data Sinkron
                        </span>
                    </div>

                    <h3 class="fw-bold text-white mb-1" style="letter-spacing: -0.5px;">
                        Selamat Datang, <span style="background: linear-gradient(90deg, #ffffff, #93c5fd); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ Auth::user()->name }}</span>
                    </h3>
                    <p class="text-white-50 mb-3 small" style="max-width: 620px; line-height: 1.55;">
                        Pantau operasional sirkulasi inventaris, verifikasi izin peminjaman mahasiswa Polije, dan kelola ketersediaan sarana prasarana 3 laboratorium secara terpusat.
                    </p>

                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <a href="{{ route('admin.items.create') }}" class="btn btn-sm btn-primary fw-semibold px-3 py-2 shadow-sm rounded-3 d-inline-flex align-items-center gap-1.5" style="background: #3b6ea5; border: none;">
                            <i class="bi bi-plus-circle-fill"></i> Tambah Sarpras Baru
                        </a>
                        <a href="{{ route('admin.borrowings.index', ['status' => 'menunggu']) }}" class="btn btn-sm fw-semibold px-3 py-2 rounded-3 text-white d-inline-flex align-items-center gap-1.5" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                            <i class="bi bi-inbox-fill text-warning"></i> Verifikasi Pengajuan 
                            @if($pendingBorrowings > 0)
                                <span class="badge bg-danger rounded-pill ms-1">{{ $pendingBorrowings }}</span>
                            @endif
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-link text-white-50 text-decoration-none px-2 py-1 small">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Katalog Publik
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end d-none d-lg-block">
                    <div class="p-3 rounded-4 d-inline-block text-start" style="background: rgba(255, 255, 255, 0.07); border: 1px solid rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); min-width: 250px;">
                        <div class="text-white-50 small mb-1">
                            <i class="bi bi-calendar3 me-1 text-primary"></i> Tanggal Operasional
                        </div>
                        <div class="fw-bold text-white fs-6">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2 pt-2 border-top border-white border-opacity-10 text-white-50 small">
                            <span class="badge py-1 px-2.5 rounded-pill" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.4); font-size: 0.72rem; font-weight: 700;">Aktif</span>
                            <span style="font-size: 0.78rem;">Lab JTI Politeknik Negeri Jember</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======================================================== -->
    <!-- 2. EXECUTIVE KPI STATISTIC CARDS (4 KARTU BERSIH & MEWAH) -->
    <!-- ======================================================== -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Aset -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden border-0 shadow-sm" style="background: #ffffff; border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem; letter-spacing: 0.6px;">Total Aset Sarpras</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0" style="letter-spacing: -0.5px;">{{ number_format($totalItems) }} <span class="fs-6 fw-normal text-muted">Unit</span></h2>
                    </div>
                    <div class="metric-icon-box" style="background: rgba(59, 110, 165, 0.12); color: #3b6ea5;">
                        <i class="bi bi-boxes"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between small text-muted mt-3 pt-2.5 border-top">
                    <span class="d-flex align-items-center gap-1.5">
                        <i class="bi bi-building text-primary"></i> 3 Laboratorium
                    </span>
                    <span class="fw-semibold text-primary">100% Terdata</span>
                </div>
                <div class="progress mt-2.5" style="height: 4px; background-color: #f1f5f9; border-radius: 4px;">
                    <div class="progress-bar bg-primary" style="width: 100%; border-radius: 4px;"></div>
                </div>
            </div>
        </div>

        <!-- Card 2: Siap Pakai -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden border-0 shadow-sm" style="background: #ffffff; border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem; letter-spacing: 0.6px;">Stok Siap Dipinjam</span>
                        <h2 class="fw-bold text-success mt-1 mb-0" style="letter-spacing: -0.5px;">{{ number_format($tersediaItems) }} <span class="fs-6 fw-normal text-muted">Unit</span></h2>
                    </div>
                    <div class="metric-icon-box" style="background: rgba(16, 185, 129, 0.08); color: #059669;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between small mt-3 pt-2.5 border-top">
                    <span class="badge fw-bold py-1 px-2.5 rounded-pill" style="background: rgba(16, 185, 129, 0.12); color: #047857; border: 1px solid rgba(16, 185, 129, 0.25); font-size: 0.74rem;">
                        {{ $persenTersedia }}% Tersedia
                    </span>
                    <span class="text-muted" style="font-size: 0.78rem;">Kondisi Baik di Lab</span>
                </div>
                <div class="progress mt-2.5" style="height: 4px; background-color: #f1f5f9; border-radius: 4px;">
                    <div class="progress-bar bg-success" style="width: {{ $persenTersedia }}%; border-radius: 4px;"></div>
                </div>
            </div>
        </div>

        <!-- Card 3: Sedang Dipinjam -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden border-0 shadow-sm" style="background: #ffffff; border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem; letter-spacing: 0.6px;">Sedang Dipinjam</span>
                        <h2 class="fw-bold mt-1 mb-0" style="color: #d97706; letter-spacing: -0.5px;">{{ number_format($dipinjamItems) }} <span class="fs-6 fw-normal text-muted">Unit</span></h2>
                    </div>
                    <div class="metric-icon-box" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between small mt-3 pt-2.5 border-top">
                    <span class="badge fw-bold py-1 px-2.5 rounded-pill" style="background: rgba(245, 158, 11, 0.12); color: #b45309; border: 1px solid rgba(245, 158, 11, 0.25); font-size: 0.74rem;">
                        {{ $persenDipinjam }}% Aktif
                    </span>
                    <span class="text-muted" style="font-size: 0.78rem;">Digunakan Mahasiswa</span>
                </div>
                <div class="progress mt-2.5" style="height: 4px; background-color: #f1f5f9; border-radius: 4px;">
                    <div class="progress-bar bg-warning" style="width: {{ $persenDipinjam }}%; background-color: #d97706 !important; border-radius: 4px;"></div>
                </div>
            </div>
        </div>

        <!-- Card 4: Menunggu Persetujuan / Perlu Verifikasi -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-ui p-4 h-100 position-relative overflow-hidden border-0 shadow-sm {{ $pendingBorrowings > 0 ? 'border border-danger border-opacity-50' : '' }}" 
                style="background: {{ $pendingBorrowings > 0 ? 'linear-gradient(180deg, #ffffff 0%, #fff7f7 100%)' : '#ffffff' }}; border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="{{ $pendingBorrowings > 0 ? 'text-danger' : 'text-muted' }} small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem; letter-spacing: 0.6px;">
                            Perlu Verifikasi
                        </span>
                        <h2 class="fw-bold {{ $pendingBorrowings > 0 ? 'text-danger' : 'text-dark' }} mt-1 mb-0" style="letter-spacing: -0.5px;">
                            {{ $pendingBorrowings }} <span class="fs-6 fw-normal text-muted">Permohonan</span>
                        </h2>
                    </div>
                    <div class="metric-icon-box position-relative" style="background: rgba(239, 68, 68, 0.08); color: #dc2626;">
                        <i class="bi bi-bell-fill"></i>
                        @if($pendingBorrowings > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-1.5 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between small mt-3 pt-2.5 border-top">
                    @if($pendingBorrowings > 0)
                        <span class="text-danger fw-bold d-flex align-items-center gap-1">
                            <span class="pulse-online" style="background-color: #ef4444;"></span> Tindakan Segera
                        </span>
                        <a href="{{ route('admin.borrowings.index', ['status' => 'menunggu']) }}" class="text-danger fw-semibold small text-decoration-none">
                            Tinjau <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <span class="text-success fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-check-circle-fill"></i> Semua Tuntas
                        </span>
                        <span class="text-muted" style="font-size: 0.78rem;">Tidak ada antrean</span>
                    @endif
                </div>
                <div class="progress mt-2.5" style="height: 4px; background-color: #f1f5f9; border-radius: 4px;">
                    <div class="progress-bar bg-danger" style="width: {{ $pendingBorrowings > 0 ? '100' : '0' }}%; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======================================================== -->
    <!-- 3. VISUAL ANALYTICS ROW (GRAFIK REAL-TIME & DONUT LAB)   -->
    <!-- ======================================================== -->
    <div class="row g-3 mb-4">
        <!-- Grafik 1: Tren Aktivitas 7 Hari Terakhir -->
        <div class="col-lg-8">
            <div class="card card-ui border-0 shadow-sm p-4 h-100" style="border-radius: 16px;">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-activity text-primary"></i> Tren Aktivitas Peminjaman Sarpras
                        </h6>
                        <span class="text-muted small">Statistik jumlah peminjaman barang per hari selama 7 hari terakhir</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-primary border px-2.5 py-1.5 small fw-semibold">
                            <i class="bi bi-clock-history me-1"></i> 7 Hari Terakhir
                        </span>
                    </div>
                </div>
                <div style="height: 250px; position: relative;">
                    <canvas id="borrowTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik 2: Komposisi Inventaris per Kategori -->
        <div class="col-lg-4">
            <div class="card card-ui border-0 shadow-sm p-4 h-100" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-pie-chart-fill text-warning"></i> Distribusi Aset 3 Lab
                        </h6>
                        <span class="text-muted small">Porsi unit barang per kelompok</span>
                    </div>
                </div>
                <div style="height: 180px; position: relative;" class="my-auto">
                    <canvas id="categoryDonutChart"></canvas>
                </div>
                <div class="d-flex justify-content-around text-center border-top pt-3 mt-3 small text-muted">
                    <div>
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #4f46e5;"></span>
                        <div class="fw-semibold text-dark">Alat Musik</div>
                    </div>
                    <div>
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #d97706;"></span>
                        <div class="fw-semibold text-dark">Alat Syuting</div>
                    </div>
                    <div>
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #0284c7;"></span>
                        <div class="fw-semibold text-dark">PC & Komputer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======================================================== -->
    <!-- 4. TABEL PENGAJUAN TERBARU (FULL WIDTH AGAR LEGA & TIDAK GESER) -->
    <!-- ======================================================== -->
    <div class="card card-ui border-0 shadow-sm mb-4 overflow-hidden" style="border-radius: 16px;">
        
        <!-- Table Header with Quick Status Filter Tabs -->
        <div class="p-4 border-bottom bg-white">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-medical-fill text-primary"></i> Permohonan Peminjaman Terbaru
                    </h6>
                    <span class="text-muted small">Kelola dan verifikasi surat peminjaman yang masuk dari mahasiswa</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary btn-sm px-3 fw-semibold rounded-3">
                        <i class="bi bi-list-ul me-1"></i> Buka Semua Data
                    </a>
                </div>
            </div>

            <!-- Client-side Quick Status Filter Pills -->
            <div class="d-flex flex-wrap gap-1.5" id="statusFilterGroup">
                <button type="button" class="btn btn-sm btn-primary active px-3 py-1 rounded-pill filter-btn fw-semibold" data-filter="all">
                    Semua ({{ $recentBorrowings->count() }})
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1 rounded-pill filter-btn fw-semibold position-relative" data-filter="menunggu">
                    Menunggu Verifikasi
                    @if($pendingBorrowings > 0)
                        <span class="badge bg-danger rounded-pill ms-1">{{ $pendingBorrowings }}</span>
                    @endif
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1 rounded-pill filter-btn fw-semibold" data-filter="disetujui">
                    Sedang Dipinjam ({{ $activeBorrowings }})
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1 rounded-pill filter-btn fw-semibold" data-filter="selesai">
                    Selesai ({{ $completedBorrowings }})
                </button>
            </div>
        </div>

        <!-- Table Content -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="recentBorrowingsTable" style="font-size: 0.86rem; min-width: 700px; width: 100%;">
                <thead class="table-light text-secondary small text-uppercase" style="letter-spacing: 0.5px; font-size: 0.74rem;">
                    <tr>
                        <th class="ps-4 py-3" style="width: 28%;">Peminjam / Mahasiswa</th>
                        <th class="py-3" style="width: 28%;">Barang yang Dipinjam</th>
                        <th class="py-3" style="width: 20%;">Jadwal & Waktu</th>
                        <th class="py-3 text-center" style="width: 12%;">Status</th>
                        <th class="text-end pe-4 py-3" style="width: 12%;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBorrowings as $b)
                        <tr class="borrowing-row" data-status="{{ $b->status }}">
                            <!-- Kolom Identitas & WhatsApp -->
                            <td class="ps-4 py-3 align-middle">
                                <div class="d-flex align-items-start" style="gap: 14px;">
                                    <!-- Avatar Circle -->
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0 mt-0.5" 
                                        style="width: 38px; height: 38px; font-size: 0.82rem; background: linear-gradient(135deg, #4272a8, #2c598a); border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(59, 110, 165, 0.22);">
                                        {{ strtoupper(substr($b->nama_peminjam, 0, 2)) }}
                                    </div>

                                    <!-- Detail Data Peminjam (Tersusun Rapi) -->
                                    <div style="min-width: 0;">
                                        <!-- Baris 1: Nama Peminjam -->
                                        <div class="fw-bold text-dark text-truncate" style="font-size: 0.88rem; line-height: 1.25;" title="{{ $b->nama_peminjam }}">
                                            {{ $b->nama_peminjam }}
                                        </div>

                                        <!-- Baris 2: NIM -->
                                        <div class="text-muted mt-0.5" style="font-size: 0.76rem; line-height: 1.3;">
                                            <span class="text-secondary fw-medium">NIM:</span> 
                                            <span class="text-dark fw-semibold">{{ $b->nim_nip }}</span>
                                        </div>

                                        <!-- Baris 3: WhatsApp Link -->
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

                                        <!-- Baris 4: Kode Transaksi (di bawah WA) -->
                                        <div class="mt-1">
                                            <span class="badge font-monospace fw-semibold px-1.5 py-0.5" 
                                                style="background: rgba(59, 110, 165, 0.08); color: #3b6ea5; border: 1px solid rgba(59, 110, 165, 0.22); font-size: 0.70rem; letter-spacing: 0.3px;" 
                                                title="Kode Transaksi: {{ $b->kode_transaksi }}">
                                                {{ $b->kode_transaksi }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                                    <!-- Kolom Sarana Prasarana (Multi-item support) -->
                                    <td class="py-3">
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($b->details as $d)
                                                <div>
                                                    <span class="badge bg-light text-dark border small fw-normal py-1 px-2 rounded-2">
                                                        <i class="bi bi-box-seam me-1 text-secondary"></i>
                                                        <strong>{{ $d->item->nama_barang }}</strong>
                                                        <span class="text-primary fw-bold ms-1">({{ $d->jumlah }} unit)</span>
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Kolom Jadwal & Jam -->
                                    <td class="py-3 small" style="white-space: nowrap;">
                                        <div class="fw-semibold text-dark">
                                            <i class="bi bi-calendar-event me-1 text-muted"></i>{{ $b->tanggal_pinjam->format('d/m/Y') }} 
                                            <span class="text-muted font-monospace fw-normal">s/d</span> 
                                            <span class="text-danger fw-bold">{{ $b->tanggal_kembali->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="text-muted mt-0.5" style="font-size: 0.76rem;">
                                            <i class="bi bi-clock me-1 text-primary"></i>{{ $b->rentang_waktu }}
                                        </div>
                                        @if(!empty($b->lokasi_penggunaan))
                                        <div class="mt-1 d-flex align-items-center gap-1" style="font-size: 0.74rem; white-space: normal; max-width: 190px;">
                                            <i class="bi bi-geo-alt-fill text-danger flex-shrink-0"></i>
                                            <span class="fw-semibold text-danger-emphasis">{{ $b->lokasi_penggunaan }}</span>
                                        </div>
                                        @endif
                                    </td>

                                    <!-- Kolom Status -->
                                    <td class="py-3" style="white-space: nowrap;">
                                        <span class="badge {{ $b->status_badge }} px-2.5 py-1 rounded-pill small fw-semibold">
                                            {{ $b->status_label }}
                                        </span>
                                    </td>

                                    <!-- Kolom Tindakan Cepat -->
                                    <td class="text-end pe-4 py-3" style="white-space: nowrap;">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.borrowings.show', $b->id) }}" class="btn btn-primary px-2.5 fw-semibold shadow-sm" title="Kelola & Verifikasi">
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
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        <h6 class="fw-bold text-dark">Belum Ada Permohonan Peminjaman</h6>
                                        <p class="small text-muted mb-0">Permohonan peminjaman sarana prasarana yang diajukan mahasiswa akan muncul di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Informasi -->
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center small text-muted px-4">
                    <div>
                        Menampilkan <strong>{{ $recentBorrowings->count() }}</strong> permohonan peminjaman sarpras terbaru.
                    </div>
                    <a href="{{ route('admin.borrowings.index') }}" class="text-primary fw-semibold text-decoration-none">
                        Lihat Seluruh Arsip & Riwayat <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Chart Tren Peminjaman (Area Spline Chart) dengan data dinamis
    const trendCanvas = document.getElementById('borrowTrendChart');
    if (trendCanvas) {
        const ctxTrend = trendCanvas.getContext('2d');
        const gradient = ctxTrend.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        const trendLabels = {!! json_encode($trendLabels) !!};
        const trendValues = {!! json_encode($trendValues) !!};

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Peminjaman',
                    data: trendValues,
                    borderColor: '#3b6ea5',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.38,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b6ea5',
                    pointBorderWidth: 2.5,
                    pointRadius: 4.5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#091322',
                        titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Permohonan Peminjaman';
                            }
                        }
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
                        ticks: { stepSize: 1, precision: 0, font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
                    }
                }
            }
        });
    }

    // 2. Chart Komposisi Kategori (Doughnut Chart) dengan data dinamis
    const donutCanvas = document.getElementById('categoryDonutChart');
    if (donutCanvas) {
        const ctxDonut = donutCanvas.getContext('2d');
        const donutLabels = {!! json_encode($categoryDonutLabels) !!};
        const donutData = {!! json_encode($categoryDonutData) !!};

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: donutLabels,
                datasets: [{
                    data: donutData,
                    backgroundColor: ['#4f46e5', '#d97706', '#0284c7'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6
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
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' Unit';
                            }
                        }
                    }
                }
            }
        });
    }

    // 3. Client-Side Interactive Filter Tabs for Permohonan Masuk
    const filterButtons = document.querySelectorAll('#statusFilterGroup .filter-btn');
    const tableRows = document.querySelectorAll('#recentBorrowingsTable tbody tr.borrowing-row');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Update active state of buttons
            filterButtons.forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary', 'active');

            const filterValue = this.getAttribute('data-filter');

            tableRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (filterValue === 'all' || rowStatus === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush
