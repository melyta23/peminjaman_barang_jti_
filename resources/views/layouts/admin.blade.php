<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Console') - SIPEMBAR MMC Polije</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-polije.png') }}">

    <!-- Bootstrap 5.3.3 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js untuk Grafik Interaktif Modern -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bs-primary: #3b6ea5;
            --bs-primary-rgb: 59, 110, 165;
            --sidebar-w: 270px;
            --navy-dark: #08111e;
            --navy-card: #0f1d32;
            --primary: #3b6ea5;
            --primary-hover: #2f5986;
            --slate-bg: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-ui: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--slate-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            margin: 0;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* SIDEBAR MODERN EXECUTIVE */
        .admin-sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, #091322 0%, #060b14 100%);
            color: #94a3b8;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Ambient subtle aura inside sidebar top */
        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 220px;
            background: radial-gradient(ellipse at 50% 0%, rgba(37, 99, 235, 0.18) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .sidebar-brand {
            padding: 1.3rem 1.35rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.015);
        }

        .sidebar-brand-logo {
            width: 42px;
            height: 42px;
            background: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.15);
            transition: transform 0.2s ease;
        }

        .sidebar-brand:hover .sidebar-brand-logo {
            transform: scale(1.05);
        }

        .sidebar-menu {
            padding: 1rem 0.75rem;
            flex-grow: 1;
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        .menu-header {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            padding: 0.85rem 0.65rem 0.35rem 0.65rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .menu-header::after {
            content: '';
            flex-grow: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0.75rem;
            color: #94a3b8;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.86rem;
            text-decoration: none;
            margin-bottom: 3px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar-link-content {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .link-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.2s ease;
            color: #94a3b8;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(3px);
        }

        .sidebar-link:hover .link-icon-box {
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
        }

        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #3b6ea5 0%, #2f5986 100%);
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(59, 110, 165, 0.35);
        }

        .sidebar-link.active .link-icon-box {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .sidebar-link-action {
            border: 1px dashed rgba(34, 197, 94, 0.4);
            background: rgba(34, 197, 94, 0.06);
            color: #4ade80;
        }

        .sidebar-link-action:hover {
            background: rgba(34, 197, 94, 0.16);
            border-color: rgba(34, 197, 94, 0.7);
            color: #ffffff;
        }

        .sidebar-link-action .link-icon-box {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        /* Sidebar Mini Status Widget */
        .sidebar-widget {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 12px;
            padding: 12px 14px;
            margin: 14px 4px 8px 4px;
        }

        /* Sidebar User Footer */
        .sidebar-user {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 1;
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b6ea5 0%, #0a1f44 100%);
            border: 2px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        /* Soft Blue Overrides for Admin Components */
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
            color: #ffffff !important;
        }
        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }
        .text-primary {
            color: var(--primary) !important;
        }
        .bg-primary:not([class*="bg-opacity"]) {
            background-color: var(--primary) !important;
        }
        .border-primary {
            border-color: var(--primary) !important;
        }

        .btn-sidebar-logout {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.25);
            background: rgba(239, 68, 68, 0.08);
            color: #f87171;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-sidebar-logout:hover {
            background: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
            transform: scale(1.06);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }

        /* Backdrop overlay for mobile */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(10, 19, 34, 0.65);
            backdrop-filter: blur(3px);
            z-index: 1035;
        }
        .sidebar-backdrop.show {
            display: block;
        }

        /* MAIN WRAPPER */
        .admin-main {
            margin-left: var(--sidebar-w);
            flex-grow: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-w));
            background: radial-gradient(circle at 50% 0%, rgba(37, 99, 235, 0.04) 0%, transparent 60%), #f8fafc;
        }

        /* TOPBAR ADMIN */
        .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-ui);
            padding: 0.85rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* CARDS & UI ELEMENTS */
        .card-ui {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 6px 16px rgba(15, 23, 42, 0.02);
            transition: all 0.25s ease;
        }

        .card-ui:hover {
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06);
            border-color: #cbd5e1;
        }

        .metric-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        /* Pulsing Dot */
        .pulse-online {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-ring 2s infinite;
        }

        .pulse-offline {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #ef4444;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: pulse-ring-red 2s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        @keyframes pulse-ring-red {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media (max-width: 991px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $pendingCount = \App\Models\Borrowing::where('status', 'menunggu')->count();
    @endphp

    <!-- BACKDROP OVERLAY FOR MOBILE -->
    <div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- 1. SIDEBAR ADMINISTRATOR -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand Header -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Politeknik Negeri Jember" width="30" height="30" style="object-fit: contain;">
            </div>
            <div class="d-flex flex-column overflow-hidden">
                <div class="d-flex align-items-center gap-1.5">
                    <span class="text-white fw-bold fs-6" style="letter-spacing: -0.3px;">SIPEMBAR MMC</span>
                </div>
                <span class="text-white-50 small text-truncate" style="font-size: 0.68rem; letter-spacing: 0.5px;">POLIJE COMMAND CENTER</span>
            </div>
        </a>

        <!-- Sidebar Navigation Menu -->
        <div class="sidebar-menu">
            <div class="menu-header">Menu Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="sidebar-link-content">
                    <div class="link-icon-box"><i class="bi bi-grid-1x2-fill"></i></div>
                    <span>Dashboard Kontrol</span>
                </div>
            </a>

            <a href="{{ route('admin.borrowings.index') }}" class="sidebar-link {{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">
                <div class="sidebar-link-content">
                    <div class="link-icon-box"><i class="bi bi-inbox-fill"></i></div>
                    <span>Data Peminjaman</span>
                </div>
                @if($pendingCount > 0)
                    <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.72rem; box-shadow: 0 0 10px rgba(239,68,68,0.5);">{{ $pendingCount }}</span>
                @endif
            </a>

            <div class="menu-header mt-3">Inventaris 3 Lab MMC</div>
            
            <a href="{{ route('admin.items.index') }}" class="sidebar-link {{ request()->routeIs('admin.items.index') && !request('category_id') ? 'active' : '' }}">
                <div class="sidebar-link-content">
                    <div class="link-icon-box"><i class="bi bi-collection-fill"></i></div>
                    <span>Semua Sarpras Lab</span>
                </div>
                <span class="badge" style="background: rgba(255, 255, 255, 0.12); color: rgba(255, 255, 255, 0.85); font-size: 0.72rem; padding: 3px 8px; border-radius: 50rem;">{{ \App\Models\Item::sum('stok_total') }}</span>
            </a>

            <a href="{{ route('admin.items.index', ['category_id' => 1]) }}" class="sidebar-link {{ request('category_id') == 1 ? 'active' : '' }}">
                <div class="sidebar-link-content">
                    <div class="link-icon-box" style="color: #818cf8;"><i class="bi bi-music-note-beamed"></i></div>
                    <span>Alat Musik & Audio</span>
                </div>
                <span class="small text-white-50" style="font-size: 0.72rem;">Lab 1</span>
            </a>

            <a href="{{ route('admin.items.index', ['category_id' => 2]) }}" class="sidebar-link {{ request('category_id') == 2 ? 'active' : '' }}">
                <div class="sidebar-link-content">
                    <div class="link-icon-box" style="color: #fbbf24;"><i class="bi bi-camera-video-fill"></i></div>
                    <span>Alat Syuting & Video</span>
                </div>
                <span class="small text-white-50" style="font-size: 0.72rem;">Lab 2</span>
            </a>

            <a href="{{ route('admin.items.index', ['category_id' => 3]) }}" class="sidebar-link {{ request('category_id') == 3 ? 'active' : '' }}">
                <div class="sidebar-link-content">
                    <div class="link-icon-box" style="color: #38bdf8;"><i class="bi bi-pc-display"></i></div>
                    <span>PC & Lab Komputer</span>
                </div>
                <span class="small text-white-50" style="font-size: 0.72rem;">Lab 3</span>
            </a>

            <div class="mt-2 mb-1">
                <a href="{{ route('admin.items.create') }}" class="sidebar-link sidebar-link-action {{ request()->routeIs('admin.items.create') ? 'active' : '' }}">
                    <div class="sidebar-link-content">
                        <div class="link-icon-box"><i class="bi bi-plus-lg"></i></div>
                        <span class="fw-semibold">Tambah Sarana Baru</span>
                    </div>
                    <i class="bi bi-arrow-right-short small"></i>
                </a>
            </div>

            <!-- Mini Live Status Card inside Sidebar -->
            <div class="sidebar-widget">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-white small fw-semibold d-flex align-items-center gap-1.5" style="font-size: 0.75rem;">
                        <span id="adminStatusDot" class="pulse-online me-1"></span>
                        <span id="adminStatusText">Sistem Terhubung</span>
                    </span>
                    <span id="adminStatusBadge" class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.4); font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">ONLINE</span>
                </div>
                <div class="d-flex justify-content-between text-white-50" style="font-size: 0.72rem;">
                    <span>Inventaris Lab</span>
                    <strong class="text-white">{{ \App\Models\Item::count() }} Jenis Sarpras</strong>
                </div>
            </div>

            <div class="menu-header mt-2">Akses Cepat & Publik</div>
            
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <div class="sidebar-link-content">
                    <div class="link-icon-box"><i class="bi bi-globe2"></i></div>
                    <span>Halaman Publik</span>
                </div>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>

            <a href="{{ route('peminjaman.tracking') }}" target="_blank" class="sidebar-link">
                <div class="sidebar-link-content">
                    <div class="link-icon-box"><i class="bi bi-search"></i></div>
                    <span>Lacak Surat Peminjam</span>
                </div>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>
        </div>

        <!-- Sidebar User Profile Footer -->
        <div class="sidebar-user">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                    <div class="sidebar-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-white small fw-bold text-truncate" style="max-width: 135px;" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="text-white-50 d-flex align-items-center gap-1" style="font-size: 0.7rem;">
                            <span class="pulse-online" style="width:6px; height:6px;"></span>
                            <span class="text-truncate">Laboran Admin</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn-sidebar-logout" title="Keluar / Logout">
                        <i class="bi bi-power"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- 2. MAIN CONTENT AREA -->
    <div class="admin-main">
        <!-- Topbar Header -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none p-1.5 rounded border" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.3px;">@yield('page_title', 'Pusat Kontrol Laboran')</h5>
                    <span class="text-muted small">Jurusan Teknologi Informasi • Politeknik Negeri Jember</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Status Badge -->
                <div class="d-none d-sm-flex align-items-center gap-2 bg-light px-3 py-1.5 rounded-pill border small">
                    <span id="topbarStatusDot" class="pulse-online"></span>
                    <span class="text-muted">Status Server:</span>
                    <strong id="topbarStatusText" class="text-success">Live & Sinkron</strong>
                </div>

                <!-- Notifikasi Cepat -->
                <a href="{{ route('admin.borrowings.index', ['status' => 'menunggu']) }}" class="btn btn-light position-relative p-2 rounded-circle border" title="Pengajuan Menunggu">
                    <i class="bi bi-bell-fill text-secondary"></i>
                    @if($pendingCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </div>
        </header>

        <!-- Flash Message Alerts -->
        <div class="container-fluid px-4 mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Page Dynamic Content -->
        <main class="container-fluid px-4 py-3 flex-grow-1">
            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="bg-white border-top py-3 px-4 text-muted small d-flex justify-content-between align-items-center">
            <div>&copy; {{ date('Y') }} Sistem Peminjaman Sarpras Laboratorium — MMC Polije.</div>
            <div class="text-primary fw-semibold">SIPEMBAR MMC v2.0 Enterprise</div>
        </footer>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('show');
            if (backdrop) backdrop.classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const statusDot = document.getElementById('adminStatusDot');
            const statusText = document.getElementById('adminStatusText');
            const statusBadge = document.getElementById('adminStatusBadge');
            const topbarDot = document.getElementById('topbarStatusDot');
            const topbarText = document.getElementById('topbarStatusText');

            function setAdminServerStatus(isOnline) {
                if (statusDot && statusText && statusBadge) {
                    if (isOnline) {
                        statusDot.className = 'pulse-online me-1';
                        statusText.textContent = 'Sistem Terhubung';
                        statusBadge.textContent = 'ONLINE';
                        statusBadge.style.background = 'rgba(34, 197, 94, 0.2)';
                        statusBadge.style.color = '#4ade80';
                        statusBadge.style.border = '1px solid rgba(74, 222, 128, 0.4)';
                    } else {
                        statusDot.className = 'pulse-offline me-1';
                        statusText.textContent = 'Sistem Terputus';
                        statusBadge.textContent = 'OFF';
                        statusBadge.style.background = 'rgba(239, 68, 68, 0.2)';
                        statusBadge.style.color = '#f87171';
                        statusBadge.style.border = '1px solid rgba(248, 113, 113, 0.45)';
                    }
                }
                if (topbarDot && topbarText) {
                    if (isOnline) {
                        topbarDot.className = 'pulse-online';
                        topbarText.textContent = 'Live & Sinkron';
                        topbarText.className = 'text-success';
                    } else {
                        topbarDot.className = 'pulse-offline';
                        topbarText.textContent = 'Offline / Terputus';
                        topbarText.className = 'text-danger';
                    }
                }
            }

            async function checkAdminServerStatus() {
                if (!navigator.onLine) {
                    setAdminServerStatus(false);
                    return;
                }
                const controller = new AbortController();
                const timer = setTimeout(() => controller.abort(), 3000);
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    const res = await fetch("{{ route('api.admin_heartbeat') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        cache: 'no-store',
                        signal: controller.signal
                    });
                    clearTimeout(timer);
                    setAdminServerStatus(res.ok);
                } catch (e) {
                    clearTimeout(timer);
                    setAdminServerStatus(false);
                }
            }

            checkAdminServerStatus();
            setInterval(checkAdminServerStatus, 4000);
            window.addEventListener('online', checkAdminServerStatus);
            window.addEventListener('offline', () => setAdminServerStatus(false));
        });
    </script>
    @stack('scripts')
</body>
</html>

