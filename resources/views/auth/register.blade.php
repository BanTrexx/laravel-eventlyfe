@extends('layouts.app')

@section('title', 'Daftar Akun - EventLyfe')

@section('content')
<div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center py-5">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 bg-surface">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/eventlyfe_1.png') }}" alt="Logo" height="60" class="mb-3">
                        </a>
                        <h3 class="fw-bold text-auth-header">Buat Akun Baru</h3>
                        <p class="text-muted small">Bergabunglah dengan komunitas EventLyfe hari ini</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-bold small text-auth-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-input-custom border-0"><i class="bi bi-person text-muted"></i></span>
                                <input id="full_name" type="text" class="form-control bg-input-custom border-0 @error('full_name') is-invalid @enderror"
                                    name="full_name" value="{{ old('full_name') }}" required autocomplete="name" autofocus placeholder="Nama lengkap Anda">
                            </div>
                            @error('full_name')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold small text-auth-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-input-custom border-0"><i class="bi bi-at text-muted"></i></span>
                                <input id="username" type="text" class="form-control bg-input-custom border-0 @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" required placeholder="username_unik">
                            </div>
                            @error('username')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small text-auth-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-input-custom border-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-input-custom border-0 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold small text-auth-label">Kata Sandi</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control bg-input-custom border-0 @error('password') is-invalid @enderror"
                                        name="password" required placeholder="Minimal 8 karakter">
                                    <span class="input-group-text bg-input-custom border-0 cursor-pointer toggle-password" data-target="password">
                                        <i class="bi bi-eye text-muted"></i>
                                    </span>
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3 mt-md-0">
                                <label for="password-confirm" class="form-label fw-bold small text-auth-label">Konfirmasi</label>
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control bg-input-custom border-0"
                                        name="password_confirmation" required placeholder="Ulangi sandi">
                                    <span class="input-group-text bg-input-custom border-0 cursor-pointer toggle-password" data-target="password-confirm">
                                        <i class="bi bi-eye text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                Daftar Sekarang
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Sudah punya akun?
                                <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary">Masuk di sini</a>
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