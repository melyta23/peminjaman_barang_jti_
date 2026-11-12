@extends('layouts.app')

@section('title', 'Login Pengguna & Petugas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 mt-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-shield-lock-fill fs-1 mb-2"></i>
                    <h4 class="fw-bold mb-1">Masuk ke Sistem</h4>
                    <p class="mb-0 small text-white-50">Sistem Peminjaman Barang JTI</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email', 'admin@jti.ac.id') }}" required autofocus placeholder="nama@jti.ac.id">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                    value="admin123" required placeholder="••••••••">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember" checked>
                            <label class="form-check-label small" for="remember">Ingat Saya di Perangkat Ini</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sekarang
                        </button>
                    </form>

                    <!-- Info Akun Demo -->
                    <div class="mt-4 p-3 bg-light rounded border small">
                        <div class="fw-bold text-dark mb-1"><i class="bi bi-info-circle me-1"></i> Akun Demo Bawaan:</div>
                        <ul class="mb-0 ps-3 text-muted">
                            <li><strong>Admin / Laboran:</strong> <code>admin@jti.ac.id</code> | Pass: <code>admin123</code></li>
                            <li><strong>Mahasiswa:</strong> <code>mahasiswa@jti.ac.id</code> | Pass: <code>password123</code></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

