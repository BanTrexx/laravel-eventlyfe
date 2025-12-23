@extends('layouts.app')

@section('title', 'Semua Event - EventLyfe')

@section('content')
<div class="container py-5 mt-4">
    <div class="row mb-5 justify-content-center text-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-3">Temukan Pengalaman Baru</h1>
            <p class="text-muted">Jelajahi berbagai event menarik di seluruh penjuru kota.</p>

            <form action="{{ route('events.all') }}" method="GET" class="mt-4">
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border border-secondary border-opacity-25">
                    <span class="input-group-text bg-surface border-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control bg-surface border-0" placeholder="Cari event impianmu..." value="{{ request('search') }}">
                    <button class="btn btn-primary px-4 fw-bold" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-surface p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4">Filter</h5>

                <form action="{{ route('events.all') }}" method="GET">
                    <div class="mb-4">
                        <label class="form-label small fw-bold filter-label">LOKASI</label>
                        <select name="location" class="form-select bg-input-custom border-0" onchange="this.form.submit()">
                            <option value="">Semua Lokasi</option>
                            @foreach($locations as $loc)
                            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold filter-label">HARGA</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="price_filter" id="free">
                            <label class="form-check-label filter-label" for="free">Gratis</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="price_filter" id="paid">
                            <label class="form-check-label filter-label" for="paid">Berbayar</label>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25"> <a href="{{ route('events.all') }}" class="btn btn-outline-secondary w-100 btn-sm rounded-pill py-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                    </a>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($events as $event)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm event-card bg-surface overflow-hidden">
                        @php
                        $url = file_exists(public_path('images/events/' . $event->image))
                        ? asset('images/events/' . $event->image)
                        : asset('storage/' . $event->image);
                        @endphp
                        <img src="{{ $url }}" class="card-img-top" alt="{{ $event->name }}" style="height: 180px; object-fit: cover;">

                        <div class="card-body">
                            <span class="badge bg-{{ $event->category->color ?? 'info' }} bg-opacity-10 text-{{ $event->category->color ?? 'info' }} mb-2 fw-normal" style="font-size: 10px;">
                                {{ $event->category->name }}
                            </span>

                            <h6 class="card-title fw-bold mb-1 text-truncate">{{ $event->name }}</h6>
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $event->location }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                <a href="{{ route('event.show', $event->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search text-muted display-1"></i>
                    <p class="mt-3 text-muted">Maaf, event yang kamu cari tidak ditemukan.</p>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endsection