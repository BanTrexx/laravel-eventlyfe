@extends('layouts.app')

@section('title', 'Home - EventLyfe')

@section('content')
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        @foreach($banners as $key => $banner)
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
            class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach($banners as $key => $banner)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <img src="{{ asset('images/' . $banner['image']) }}" class="d-block w-100 banner-img" alt="{{ $banner['alt'] }}">
        </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container relative-container">
    <div class="search-panel shadow p-4 bg-white rounded-4">
        <form action="{{ route('events.all') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-muted small">Cari Event</label>
                    <input type="text" class="form-control border-0 bg-light" placeholder="Konser, Webinar, dll...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-muted small">Lokasi</label>
                    <select class="form-select border-0 bg-light">
                        <option selected>Semua Lokasi</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="bandung">Bandung</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold text-muted small">Waktu</label>
                    <input type="date" class="form-control border-0 bg-light">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary fw-bold">Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container mt-5 pt-4">
    <h5 class="fw-bold mb-4">Jelajahi Kategori</h5>
    <div class="d-flex justify-content-between justify-content-md-evenly text-center overflow-auto pb-3 pt-3 gap-3">
        @foreach($categories as $category)
        <a href="{{ route('events.all', ['category' => $category->slug]) }}" class="category-item text-decoration-none text-dark">
            <div class="icon-box bg-{{ $category->color }} bg-opacity-10 text-{{ $category->color }} mb-2 mx-auto rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi {{ $category->icon }} fs-4"></i>
            </div>
            <small class="fw-bold">{{ $category->name }}</small>
        </a>
        @endforeach
    </div>
</div>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Event Pilihan</h3>
        <a href="{{ route('events.all') }}" class="text-decoration-none fw-bold text-primary">Lihat Semua</a>
    </div>

    <div class="row g-4">
        @forelse($events as $event)
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm event-card bg-surface">
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
                    <img src="{{ $url }}" class="card-img-top rounded-top-3" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">

                    <div class="position-absolute top-0 start-0 bg-white m-2 px-2 py-1 rounded shadow-sm text-center">
                        <small class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</small>
                        <small class="d-block text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</small>
                    </div>
                </div>
                <div class="card-body">
                    <span class="badge bg-info bg-opacity-10 text-info mb-2 fw-normal" style="font-size: 10px;">
                        {{ $event->category->name }}
                    </span>
                    <h6 class="card-title fw-bold mb-1 text-truncate">{{ $event->name }}</h6>
                    <small class="text-muted mb-2 d-block"><i class="bi bi-geo-alt me-1"></i>{{ $event->location ?? 'Online' }}</small>
                    <hr class="my-2 dashed">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fw-bold text-primary mb-0">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                        <small class="text-muted" style="font-size: 11px;">{{ $event->quota }} Slot</small>
                    </div>
                </div>
                <a href="{{ route('event.show', $event->id) }}" class="stretched-link"></a>
            </div>
        </div>
        @empty
        ...
        @endforelse
    </div>
</div>

<div class="container mb-5">
    @php
    $bgImage = asset('images/banner1.jpeg');
    @endphp
    <div class="rounded-4 overflow-hidden bg-dark text-white p-5 text-center position-relative shadow-lg"
        style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ $bgImage }}'); background-size: cover; background-position: center;">
        <div class="position-relative z-1">
            <h2 class="fw-bold">Buat Event Kamu Sendiri!</h2>
            <p class="mb-4">Gabung sekarang dan jual tiketmu dengan mudah di EventLyfe.</p>
            <a href="{{ route('register.organizer') }}" class="btn btn-primary rounded-pill px-5 fw-bold shadow">Jadi Creator</a>
        </div>
    </div>
</div>
@endsection