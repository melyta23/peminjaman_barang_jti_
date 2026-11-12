<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Console') - SIPEMBAR JTI Polije</title>

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
            --sidebar-w: 260px;
            --navy-dark: #091322;
            --navy-card: #0f1d32;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
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

        /* SIDEBAR MODERN */
        .admin-sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background-color: var(--navy-dark);
            color: #94a3b8;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.25s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-brand-logo {
            width: 38px;
            height: 38px;
            background: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .sidebar-menu {
            padding: 1rem 0.75rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-header {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 0.75rem 0.75rem 0.25rem 0.75rem;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.85rem;
            color: #94a3b8;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.88rem;
            text-decoration: none;
            margin-bottom: 2px;
            transition: all 0.15s ease;
        }

        .sidebar-link i.link-icon {
            font-size: 1.1rem;
            margin-right: 10px;
            color: #64748b;
            transition: color 0.15s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link:hover i.link-icon {
            color: #38bdf8;
        }

        .sidebar-link.active {
            color: #ffffff;
            background: #2563eb;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .sidebar-link.active i.link-icon {
            color: #ffffff;
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.2);
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

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
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

    <!-- 1. SIDEBAR ADMINISTRATOR -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand Header -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <svg viewBox="0 0 100 100" width="28" height="28">
                    <polygon points="50,4 93,22 80,82 50,96 20,82 7,22" fill="#0080c8"/>
                    <circle cx="50" cy="50" r="22" fill="#ffffff"/>
                    <path d="M50,30 Q58,45 50,65 Q42,45 50,30" fill="#facc15"/>
                    <path d="M43,38 Q50,45 44,55" stroke="#15803d" stroke-width="2" fill="none"/>
                    <path d="M57,38 Q50,45 56,55" stroke="#15803d" stroke-width="2" fill="none"/>
                </svg>
            </div>
            <div class="d-flex flex-column">
                <span class="text-white fw-bold fs-6" style="letter-spacing: -0.3px;">SIPEMBAR JTI</span>
                <span class="text-white-50 small" style="font-size: 0.7rem;">COMMAND CENTER</span>
            </div>
        </a>

        <!-- Sidebar Navigation Menu -->
        <div class="sidebar-menu">
            <div class="menu-header">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div><i class="bi bi-grid-1x2-fill link-icon"></i> Dashboard Kontrol</div>
            </a>
            <a href="{{ route('admin.borrowings.index') }}" class="sidebar-link {{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">
                <div><i class="bi bi-inbox-fill link-icon"></i> Data Peminjaman</div>
                @php
                    $pendingCount = \App\Models\Borrowing::where('status', 'menunggu')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.72rem;">{{ $pendingCount }}</span>
                @endif
            </a>

            <div class="menu-header mt-3">Manajemen Inventaris 3 Lab</div>
            <a href="{{ route('admin.items.index') }}" class="sidebar-link {{ request()->routeIs('admin.items.index') && !request('category_id') ? 'active' : '' }}">
                <div><i class="bi bi-collection-fill link-icon"></i> Semua Sarpras Lab</div>
                <span class="badge bg-secondary bg-opacity-25 text-white-50 small">32 Unit</span>
            </a>
            <a href="{{ route('admin.items.index', ['category_id' => 1]) }}" class="sidebar-link {{ request('category_id') == 1 ? 'active' : '' }}">
                <div><i class="bi bi-music-note-beamed link-icon" style="color: #818cf8;"></i> Alat Musik & Audio</div>
            </a>
            <a href="{{ route('admin.items.index', ['category_id' => 2]) }}" class="sidebar-link {{ request('category_id') == 2 ? 'active' : '' }}">
                <div><i class="bi bi-camera-video-fill link-icon" style="color: #fbbf24;"></i> Alat Syuting & Video</div>
            </a>
            <a href="{{ route('admin.items.index', ['category_id' => 3]) }}" class="sidebar-link {{ request('category_id') == 3 ? 'active' : '' }}">
                <div><i class="bi bi-pc-display link-icon" style="color: #38bdf8;"></i> PC & Lab Komputer</div>
            </a>
            <a href="{{ route('admin.items.create') }}" class="sidebar-link {{ request()->routeIs('admin.items.create') ? 'active' : '' }}">
                <div><i class="bi bi-plus-circle-fill link-icon text-success"></i> Tambah Sarana Baru</div>
            </a>

            <div class="menu-header mt-3">Tautan Eksternal</div>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <div><i class="bi bi-globe link-icon"></i> Halaman Publik Mahasiswa</div>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>
            <a href="{{ route('peminjaman.tracking') }}" target="_blank" class="sidebar-link">
                <div><i class="bi bi-search link-icon"></i> Pelacakan Status Surat</div>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>
        </div>

        <!-- Sidebar User Footer -->
        <div class="sidebar-user">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle bg-primary bg-opacity-20 text-primary border border-primary border-opacity-25 d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="text-white small fw-bold text-truncate" style="max-width: 130px;">{{ Auth::user()->name }}</div>
                        <div class="text-white-50" style="font-size: 0.72rem;"><span class="pulse-online me-1"></span> Laboran JTI</div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm p-1.5 rounded-3" title="Keluar">
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
                <button class="btn btn-light d-lg-none p-1.5 rounded border" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
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
                    <span class="pulse-online"></span>
                    <span class="text-muted">Status Server:</span>
                    <strong class="text-success">Live & Sinkron</strong>
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
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center" role="alert">
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
            <div>&copy; {{ date('Y') }} Sistem Peminjaman Sarpras Laboratorium — JTI Polije.</div>
            <div class="text-primary fw-semibold">SIPEMBAR JTI v2.0 Enterprise</div>
        </footer>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

