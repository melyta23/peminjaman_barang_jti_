<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Peminjaman Sarpras') — MMC Politeknik Negeri Jember</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-polije.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #3b6ea5;
            --bs-primary-rgb: 59, 110, 165;
            --navy:   #0a1f44;
            --blue:   #3b6ea5;
            --accent: #3b6ea5;
            --sky:    #5a8ab8;
            --bg:     #f4f7fb;
            --border: #dde3ed;
            --text:   #1a202c;
            --muted:  #64748b;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── TOPBAR TIPIS ─────────────────────────── */
        .topbar {
            background: var(--navy);
            color: rgba(255,255,255,0.65);
            font-size: 0.75rem;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .topbar a { color: rgba(255,255,255,0.65); text-decoration: none; }
        .topbar a:hover { color: #fff; }
        .topbar .dot {
            display: inline-block; width: 7px; height: 7px;
            border-radius: 50%; background: #22c55e;
            margin-right: 5px; vertical-align: middle;
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink {
            0%,100% { opacity: 1; } 50% { opacity: 0.3; }
        }

        /* ─── NAVBAR UTAMA ─────────────────────────── */
        .main-navbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: 0 1px 6px rgba(10,31,68,0.07);
        }

        .main-navbar .container {
            display: flex;
            align-items: stretch;
            height: 60px;
            gap: 0;
        }

        /* Brand */
        .navbar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            padding-right: 24px;
            border-right: 1px solid var(--border);
            flex-shrink: 0;
        }
        .brand-icon {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-icon img {
            width: 40px; height: 40px;
            object-fit: contain;
            display: block;
        }
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.3px;
            line-height: 1.1;
        }
        .brand-sub {
            font-size: 0.68rem;
            color: var(--muted);
            font-weight: 500;
        }

        /* Nav links */
        .navbar-nav-links {
            display: flex;
            align-items: stretch;
            list-style: none;
            margin: 0;
            padding: 0 0 0 4px;
            gap: 0;
            flex: 1;
        }
        .navbar-nav-links li a {
            display: flex;
            align-items: center;
            gap: 6px;
            height: 100%;
            padding: 0 16px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: color 0.15s, border-color 0.15s;
            white-space: nowrap;
        }
        .navbar-nav-links li a:hover {
            color: var(--navy);
            background: #f8fafc;
            border-bottom-color: #cbd5e1;
        }
        .navbar-nav-links li a.active {
            color: var(--blue);
            border-bottom-color: var(--blue);
            background: rgba(26,86,219,0.04);
        }
        .navbar-nav-links li a i { font-size: 0.95em; }

        /* Right actions */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-left: 16px;
            border-left: 1px solid var(--border);
        }

        .btn-admin {
            background: #f59e0b;
            color: #fff !important;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.15s, transform 0.15s;
        }
        .btn-admin:hover { background: #d97706; transform: translateY(-1px); }

        .btn-portal {
            background: var(--navy);
            color: #fff !important;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.15s;
        }
        .btn-portal:hover { background: #1a3461; }

        .user-dropdown-toggle {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            cursor: pointer;
            transition: background 0.15s;
        }
        .user-dropdown-toggle:hover { background: #f1f5f9; }

        /* ─── SHARED COMPONENTS ─────────────────────── */
        .card-custom {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card-custom:hover {
            box-shadow: 0 8px 24px rgba(10,31,68,0.09);
            transform: translateY(-3px);
        }

        .btn-accent {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            border: none;
            transition: background 0.15s, transform 0.15s;
        }
        .btn-accent:hover { background: #2f5986; color: #fff; transform: translateY(-1px); }

        /* Global Soft Blue Overrides for Bootstrap Primary */
        .btn-primary {
            background-color: var(--blue) !important;
            border-color: var(--blue) !important;
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #2f5986 !important;
            border-color: #2f5986 !important;
            color: #ffffff !important;
        }
        .btn-outline-primary {
            color: var(--blue) !important;
            border-color: var(--blue) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--blue) !important;
            color: #ffffff !important;
        }
        .text-primary {
            color: var(--blue) !important;
        }
        .bg-primary:not([class*="bg-opacity"]) {
            background-color: var(--blue) !important;
        }
        .border-primary {
            border-color: var(--blue) !important;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid #d1d5db;
            padding: 0.6rem 0.9rem;
            font-size: 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,110,165,0.15);
        }

        .live-dot {
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #22c55e;
            margin-right: 4px;
            vertical-align: middle;
            animation: blink 2s ease-in-out infinite;
        }

        footer {
            margin-top: auto;
            background: var(--navy);
            color: rgba(255,255,255,0.5);
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        /* ─── RESPONSIVE MOBILE ─────────────────────── */
        @media (max-width: 575.98px) {
            .topbar { font-size: 0.7rem; padding: 5px 0; }
            .main-navbar .container { height: 54px; }
            .brand-name { font-size: 0.95rem; }
            .user-dropdown-toggle { padding: 5px 8px; font-size: 0.78rem; }
        }
        @media (max-width: 991.98px) {
            .navbar-actions { gap: 6px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- TOPBAR INFO -->
    <div class="topbar">
        <div class="container d-flex align-items-center justify-content-between">
            <span class="d-none d-md-inline">
                <span class="dot"></span>
                <strong style="color:#fff;">SIPEMBAR MMC</strong>
                &nbsp;|&nbsp; Jurusan Teknologi Informasi — Politeknik Negeri Jember
            </span>
            <span class="d-inline d-md-none">
                <span class="dot"></span>
                <strong style="color:#fff;">SIPEMBAR MMC</strong>
            </span>
            <div class="d-flex align-items-center gap-2 gap-md-3">
                <span class="d-none d-sm-inline"><i class="bi bi-clock me-1"></i>Senin – Jumat (07.30 – 16.00 WIB)</span>
                <a href="{{ route('peminjaman.tracking') }}"><i class="bi bi-search me-1"></i><span class="d-none d-sm-inline">Lacak Pengajuan</span><span class="d-inline d-sm-none">Lacak</span></a>
            </div>
        </div>
    </div>

    <!-- NAVBAR UTAMA -->
    <nav class="main-navbar">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand-wrap" href="{{ route('home') }}">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Politeknik Negeri Jember" width="40" height="40">
                </div>
                <div>
                    <div class="brand-name">SIPEMBAR MMC</div>
                    <div class="brand-sub d-none d-sm-block">Politeknik Negeri Jember</div>
                </div>
            </a>

            <!-- Nav Links (desktop only) -->
            <ul class="navbar-nav-links d-none d-lg-flex">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-grid-3x3-gap"></i> Sarana Prasarana
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.create') }}" class="{{ request()->routeIs('peminjaman.create') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-plus"></i> Buat Pengajuan
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.tracking') }}" class="{{ request()->routeIs('peminjaman.tracking') ? 'active' : '' }}">
                        <i class="bi bi-search"></i> Cek Status Surat
                    </a>
                </li>
            </ul>

            <!-- Actions -->
            <div class="navbar-actions ms-auto d-flex align-items-center gap-2">
                @if(Auth::check() && Auth::user()->isAdmin())
                    {{-- Desktop: label + icon, Mobile: icon only --}}
                    <a class="btn-admin d-none d-sm-inline-flex" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard Admin
                    </a>
                    <a class="btn-admin d-inline-flex d-sm-none" href="{{ route('admin.dashboard') }}" style="padding:7px 10px;" title="Dashboard Admin">
                        <i class="bi bi-speedometer2"></i>
                    </a>
                    <div class="dropdown">
                        <button class="user-dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle text-primary"></i>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down small text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width: 180px; border-radius: 10px; overflow: hidden;">
                            <li><span class="dropdown-item-text small text-muted py-2">{{ Auth::user()->name }}</span></li>
                            <li><hr class="dropdown-divider my-0"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger small fw-semibold py-2">
                                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn-portal d-none d-sm-inline-flex" href="{{ route('login') }}">
                        <i class="bi bi-shield-lock"></i> Portal Petugas
                    </a>
                    <a class="btn-portal d-inline-flex d-sm-none" href="{{ route('login') }}" style="padding:7px 10px;" title="Portal Petugas">
                        <i class="bi bi-shield-lock"></i>
                    </a>
                @endif

                <!-- Hamburger untuk mobile -->
                <button class="d-lg-none btn btn-sm btn-outline-secondary px-2 py-1 rounded-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-expanded="false" aria-label="Toggle menu">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>

        </div>

    </nav>

    <!-- Mobile Nav Menu (di luar sticky nav → expand mendorong konten ke bawah) -->
    <div class="collapse d-lg-none" id="mobileNav"
         style="background:#fff; border-bottom:1px solid var(--border); box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <div class="container py-2 d-flex flex-column gap-1">
            <a href="{{ route('home') }}"
               class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none fw-semibold small {{ request()->routeIs('home') ? 'text-primary bg-light' : 'text-dark' }}">
                <i class="bi bi-grid-3x3-gap"></i> Sarana Prasarana
            </a>
            <a href="{{ route('peminjaman.create') }}"
               class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none fw-semibold small {{ request()->routeIs('peminjaman.create') ? 'text-primary bg-light' : 'text-dark' }}">
                <i class="bi bi-file-earmark-plus"></i> Buat Pengajuan
            </a>
            <a href="{{ route('peminjaman.tracking') }}"
               class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none fw-semibold small {{ request()->routeIs('peminjaman.tracking') ? 'text-primary bg-light' : 'text-dark' }}">
                <i class="bi bi-search"></i> Cek Status Surat
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 d-flex align-items-center shadow-sm" role="alert"
                 style="background:#f0fdf4; color:#15803d; border-left: 4px solid #22c55e !important; border-radius: 10px !important;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 d-flex align-items-center shadow-sm" role="alert"
                 style="background:#fef2f2; color:#dc2626;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div class="fw-medium">{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="py-3 flex-fill">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-3">
        <div class="container small">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-1">
                <span>
                    <strong style="color:#fff;">Jurusan Teknologi Informasi</strong>
                    <span class="d-none d-sm-inline"> — Politeknik Negeri Jember · Jl. Mastrip PO. BOX 164 Jember 68121</span>
                    <span class="d-inline d-sm-none text-white-50"> — Politeknik Negeri Jember</span>
                </span>
                <span>&copy; {{ date('Y') }} SIPEMBAR MMC Polije</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
