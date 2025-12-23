@extends('layouts.app')

@section('title', 'Checker Dashboard - EventLyfe')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Halo, {{ auth()->user()->full_name }}!</h2>
        <p class="text-muted text-auth-label">Siap bertugas hari ini? Pilih event untuk mulai scanning.</p>
    </div>

    <h5 class="fw-bold mb-3">Event Ditugaskan</h5>

    <div class="row g-3">
        @forelse($events as $event)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm bg-surface rounded-4 overflow-hidden h-100">
                <div class="position-relative">
                    @php
                    // Cek apakah file ada di folder storage (hasil upload)
                    if (Storage::disk('public')->exists($event->image)) {
                    $url = asset('storage/' . $event->image);
                    } else {
                    // Jika tidak ada di storage, cari di folder public/images/events/
                    $url = asset('images/events/' . $event->image);
                    }
                    @endphp
                    <img src="{{ $url }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 m-3 badge bg-primary rounded-pill">
                        {{ $event->category->name }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold mb-1">{{ $event->name }}</h5>
                    <p class="small text-muted mb-3">
                        <i class="bi bi-geo-alt me-1"></i> {{ $event->location }}<br>
                        <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                    </p>

                    <a href="{{ route('checker.scan', $event->id) }}" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                        <i class="bi bi-qr-code-scan me-2"></i> Mulai Scan Tiket
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-surface p-5 rounded-4 shadow-sm">
                <i class="bi bi-clipboard-x text-muted opacity-25" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">Belum ada event yang ditugaskan untuk Anda.<br>Silakan hubungi Organizer Anda.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection