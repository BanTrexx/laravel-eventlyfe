@extends('layouts.app')

@section('title', $event->name . ' - EventLyfe')

@section('content')
<div class="container py-5 mt-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-surface mb-4">
                @php
                $url = file_exists(public_path('images/events/' . $event->image))
                ? asset('images/events/' . $event->image)
                : asset('storage/' . $event->image);
                @endphp
                <img src="{{ $url }}" class="img-fluid w-100" alt="{{ $event->name }}" style="max-height: 500px; object-fit: cover;">

                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-{{ $event->category->color }} bg-opacity-10 text-{{ $event->category->color }} px-3 py-2 rounded-pill">
                            <i class="bi {{ $event->category->icon }} me-1"></i> {{ $event->category->name }}
                        </span>
                    </div>
                    <h1 class="fw-bold mb-4">{{ $event->name }}</h1>

                    <h5 class="fw-bold mb-3">Deskripsi Acara</h5>
                    <div class="text-muted lh-lg">
                        {{ $event->description }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-sm rounded-4 bg-surface p-4 mb-4">
                    <h5 class="fw-bold mb-4">Informasi Event</h5>

                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div>
                            <small class="event-detail-label d-block">Tanggal & Waktu</small>
                            <span class="fw-bold event-detail-text">
                                {{ \Carbon\Carbon::parse($event->date)->format('d F Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <small class="event-detail-label d-block">Lokasi</small>
                            <span class="fw-bold event-detail-text">{{ $event->location }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                        <div>
                            <small class="event-detail-label d-block">Sisa Kuota</small>
                            <span class="fw-bold text-danger">{{ $event->quota }} Tiket</span>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="mb-4">
                        <small class="text-muted d-block mb-1">Harga Tiket</small>
                        <h2 class="fw-bold text-primary">Rp {{ number_format($event->price, 0, ',', '.') }}</h2>
                    </div>

                    @auth
                    {{-- Pastikan nama rute sesuai dengan yang ada di web.php (checkout.show) --}}
                    <a href="{{ route('checkout.show', $event->id) }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-cart-check me-2"></i>Beli Tiket Sekarang
                    </a>
                    @else
                    <button type="button" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#loginSuggestModal">
                        Beli Tiket Sekarang
                    </button>
                    @endauth
                </div>

                <div class="text-center">
                    <p class="text-muted small">Butuh bantuan? <a href="#" class="text-decoration-none">Hubungi Penyelenggara</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loginSuggestModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow bg-surface">
            <div class="modal-body p-5 text-center">
                <h3 class="fw-bold text-auth-header" id="modalTitle">Temukan Pengalaman Seru!</h3>
                <p class="text-muted mb-4">Masuk atau daftar sekarang untuk memesan tiket dan mendapatkan update terbaru mengenai event ini.</p>

                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary py-3 rounded-pill fw-bold">Masuk Sekarang</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary py-3 rounded-pill fw-bold">Daftar Akun Baru</a>
                </div>

                <button type="button" class="btn btn-link text-muted mt-3 text-decoration-none small" data-bs-dismiss="modal">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>
</div>

@guest
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Nama kunci unik untuk menyimpan status di browser user
        const storageKey = 'has_seen_login_suggest';

        // Cek apakah user sudah pernah melihat popup ini sebelumnya
        const hasSeenModal = localStorage.getItem(storageKey);

        if (!hasSeenModal) {
            setTimeout(function() {
                var modalElement = document.getElementById('loginSuggestModal');
                if (modalElement) {
                    var myModal = new bootstrap.Modal(modalElement, {
                        keyboard: true,
                        backdrop: true
                    });

                    myModal.show();

                    // Simpan status ke localStorage setelah modal muncul
                    // sehingga di halaman/kunjungan berikutnya tidak muncul lagi
                    localStorage.setItem(storageKey, 'true');
                }
            }, 1500);
        }
    });
</script>
@endguest
@endsection