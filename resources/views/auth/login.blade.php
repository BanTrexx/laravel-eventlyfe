@extends('layouts.app')

@section('title', 'Login - EventLyfe')

@section('content')
<div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center py-5">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 bg-surface">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/eventlyfe_1.png') }}" alt="Logo" height="60" class="mb-3">
                        </a>
                        <h3 class="fw-bold text-auth-header">Selamat Datang Kembali</h3>
                        <p class="text-muted small">Silakan masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="login" class="form-label fw-bold small text-auth-label">Email atau Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-input-custom border-0"><i class="bi bi-person-circle text-muted"></i></span>
                                <input id="login" type="text" class="form-control bg-input-custom border-0 @error('email') is-invalid @enderror @error('username') is-invalid @enderror"
                                    name="login" value="{{ old('login') }}" required autocomplete="username" autofocus placeholder="Masukkan email atau username">
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            @error('username')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-bold small text-auth-label">Kata Sandi</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-input-custom border-0"><i class="bi bi-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-input-custom border-0 @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password" placeholder="••••••••">
                                <span class="input-group-text bg-input-custom border-0 cursor-pointer toggle-password" id="togglePassword" data-target="password">
                                    <i class="bi bi-eye text-muted"></i>
                                </span>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-auth-label opacity-75" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                Masuk
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Belum punya akun?
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-primary">Daftar Sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection