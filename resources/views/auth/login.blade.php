@extends('layouts.app')

@section('title', 'Login Pengguna & Petugas — JTI Polije')

@section('content')
<style>
    .login-wrapper {
        min-height: calc(100vh - 220px);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Ambient background soft glow */
    .login-wrapper::before {
        content: '';
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 600px;
        max-width: 100%;
        height: 400px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, rgba(14, 165, 233, 0.03) 50%, transparent 75%);
        pointer-events: none;
        z-index: 0;
    }

    .login-card {
        background: #ffffff;
        border-radius: 18px !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        box-shadow: 0 20px 40px -15px rgba(10, 31, 68, 0.1), 0 0 1px 1px rgba(10, 31, 68, 0.04) !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        z-index: 1;
    }

    .login-brand-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.85rem;
    }

    .login-badge {
        background: #f0f5fa;
        color: #3b6ea5;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid rgba(59, 110, 165, 0.25);
        letter-spacing: 0.3px;
    }

    .text-navy {
        color: #0a1f44;
    }

    .login-input-group {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }

    .login-input-group:focus-within {
        border-color: #3b6ea5;
        box-shadow: 0 0 0 3px rgba(59, 110, 165, 0.15);
    }

    .login-input-group .input-group-text {
        border: none;
        background-color: #f8fafc;
        color: #64748b;
        font-size: 1rem;
        padding-left: 14px;
        padding-right: 12px;
    }

    .login-input-group .form-control {
        border: none;
        padding: 10px 14px;
        font-size: 0.92rem;
        color: #0f172a;
    }

    .login-input-group .form-control:focus {
        box-shadow: none;
    }

    .btn-login {
        background: linear-gradient(135deg, #1a56db 0%, #0a1f44 100%);
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: all 0.2s ease;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #1e40af 0%, #081735 100%);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -4px rgba(26, 86, 219, 0.35);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .demo-chip {
        border-radius: 10px;
        transition: all 0.2s ease;
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }

    .demo-chip:hover {
        background: #f8fafc;
        border-color: #93c5fd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.08);
    }

    .demo-chip.active-chip {
        border-color: #3b6ea5;
        background: #f0f5fa;
    }

    .demo-icon-badge {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .hover-primary {
        transition: color 0.15s ease;
    }
    .hover-primary:hover {
        color: #1a56db !important;
    }

    .form-check-input:checked {
        background-color: #1a56db;
        border-color: #1a56db;
    }

    .pulse-online {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #22c55e;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulse-ring-green 2s infinite;
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

    @keyframes pulse-ring-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

    @keyframes pulse-ring-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
</style>

<div class="login-wrapper py-4 py-lg-5">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-5">
                
                <!-- Brand / Portal Header -->
                <div class="text-center mb-4">
                    <div class="login-brand-icon mx-auto mb-3 shadow-sm bg-white p-2">
                        <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Politeknik Negeri Jember" width="46" height="46" style="object-fit: contain;">
                    </div>
                    <div>
                        <span class="badge rounded-pill px-3 py-1 mb-2 login-badge">
                            <i class="bi bi-patch-check-fill me-1 text-primary"></i> Portal Petugas & Laboran
                        </span>
                    </div>
                    <h3 class="fw-bold text-navy mb-1" style="letter-spacing: -0.5px;">Login Petugas Lab</h3>
                    <p class="text-muted small mb-0">Khusus Administrator & Laboran Sarana Prasarana JTI</p>
                </div>

                <!-- Main Card -->
                @php
                    $isAdminOnline = \App\Models\User::where('role', 'admin')
                        ->where('updated_at', '>=', now()->subSeconds(60))
                        ->exists();
                @endphp
                <div class="card login-card rounded-4 overflow-hidden">
                    <!-- Status Admin Online / Offline Realtime -->
                    <div class="px-4 py-2.5 d-flex align-items-center" style="background: #08111e; border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <span class="text-white small fw-semibold d-flex align-items-center gap-2" style="font-size: 0.78rem;">
                            <span id="loginStatusDot" class="{{ $isAdminOnline ? 'pulse-online' : 'pulse-offline' }}"></span>
                            <span id="loginStatusText">{{ $isAdminOnline ? 'Admin Sedang Online' : 'Admin Sedang Offline' }}</span>
                        </span>
                    </div>

                    <div class="card-body p-4 p-sm-4">

                        <!-- Informasi untuk Mahasiswa / Peminjam -->
                        <div class="alert border-0 rounded-3 small p-3 mb-4 d-flex align-items-start gap-2.5" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e !important;">
                            <i class="bi bi-info-circle-fill fs-5 text-success flex-shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="d-block text-dark mb-0.5">Mahasiswa / Peminjam tidak perlu login:</strong>
                                Anda dapat langsung membuat pengajuan tanpa akun melalui menu 
                                <a href="{{ route('peminjaman.create') }}" class="fw-bold text-success text-decoration-underline">Buat Pengajuan Baru</a>.
                            </div>
                        </div>

                        <form action="{{ route('login') }}" method="POST" id="loginForm" autocomplete="on">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-dark small mb-1">
                                    Email Petugas Laboratorium <span class="text-danger">*</span>
                                </label>
                                <div class="input-group login-input-group @error('email') border-danger @enderror">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email') }}" 
                                        required autofocus 
                                        placeholder="petugas@jti.ac.id">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold text-dark small mb-1">
                                    Kata Sandi Petugas <span class="text-danger">*</span>
                                </label>
                                <div class="input-group login-input-group @error('password') border-danger @enderror">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        value="" 
                                        required 
                                        placeholder="••••••••">
                                    <button class="btn btn-link text-muted px-3 text-decoration-none" type="button" id="togglePasswordBtn" title="Tampilkan / Sembunyikan Kata Sandi" style="background:#f8fafc; border:none;">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember & Security Info -->
                            <div class="d-flex justify-content-between align-items-center mb-4 pt-1">
                                <div class="form-check custom-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember" checked>
                                    <label class="form-check-label small text-muted user-select-none" for="remember">
                                        Ingat Saya di Perangkat Ini
                                    </label>
                                </div>
                                <span class="badge bg-light text-secondary border small fw-normal py-1 px-2">
                                    <i class="bi bi-shield-check text-success me-1"></i> Terenkripsi
                                </span>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 btn-login shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <span>Masuk ke Panel Petugas</span>
                                <i class="bi bi-box-arrow-in-right"></i>
                            </button>
                        </form>

                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-light px-4 py-3 border-0 text-center small text-muted d-flex align-items-center justify-content-center gap-2" style="border-top: 1px solid #f1f5f9 !important;">
                        <i class="bi bi-lock-fill text-muted"></i>
                        <span>Keamanan Sesi Terjamin · JTI Politeknik Negeri Jember</span>
                    </div>
                </div>

                <!-- Nav back link -->
                <div class="text-center mt-3">
                    <a href="{{ route('katalog') }}" class="text-decoration-none small text-muted d-inline-flex align-items-center gap-1 hover-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Katalog Barang Publik
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.className = isPassword ? 'bi bi-eye-slash text-primary' : 'bi bi-eye';
            });
        }

        // Real-time status server check (Admin Online hijau / Offline merah)
        const statusDot = document.getElementById('loginStatusDot');
        const statusText = document.getElementById('loginStatusText');

        function setServerStatus(isOnline) {
            if (!statusDot || !statusText) return;
            if (isOnline) {
                statusDot.className = 'pulse-online';
                statusText.textContent = 'Admin Sedang Online';
            } else {
                statusDot.className = 'pulse-offline';
                statusText.textContent = 'Admin Sedang Offline';
            }
        }

        async function checkServerStatus() {
            if (!navigator.onLine) {
                setServerStatus(false);
                return;
            }
            try {
                const res = await fetch("{{ route('api.server_status') }}?t=" + Date.now(), {
                    cache: 'no-store'
                });
                if (!res.ok) return;
                const data = await res.json();
                setServerStatus(Boolean(data.admin_online));
            } catch (e) {
                // Abaikan error jaringan sesaat agar status tidak berubah-ubah sendiri
            }
        }

        checkServerStatus();
        setInterval(checkServerStatus, 5000);
        window.addEventListener('online', checkServerStatus);
        window.addEventListener('offline', () => setServerStatus(false));
    });

    function selectDemoAccount(email, password, element) {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        if (emailInput && passwordInput) {
            emailInput.value = email;
            passwordInput.value = password;

            // Highlight visual feedback
            document.querySelectorAll('.demo-chip').forEach(el => el.classList.remove('active-chip'));
            if (element) {
                element.classList.add('active-chip');
            }

            // Quick focus to submit button or password
            passwordInput.focus();
        }
    }
</script>
@endpush
@endsection
