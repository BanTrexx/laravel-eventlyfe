@extends('layouts.app')

@section('content')
<div class="container py-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-surface">
                <div class="bg-primary p-4 text-center text-white">
                    <h5 class="fw-bold mb-0">E-TICKET</h5>
                </div>

                <div class="text-center p-4 border-bottom bg-light">
                    <div class="d-inline-block p-3 rounded-4 shadow-sm mb-3" style="background-color: #ffffff !important;">
                        {{-- Memaksa QR Code digenerate dengan warna Hitam & Putih murni --}}
                        {!! QrCode::size(200)
                        ->backgroundColor(255, 255, 255)
                        ->color(0, 0, 0)
                        ->generate($ticket->ticket_code) !!}
                    </div>
                    <h4 class="fw-bold mb-0">{{ $ticket->ticket_code }}</h4>
                    <span class="badge bg-success rounded-pill px-3">TERVERIFIKASI</span>
                </div>

                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-3">{{ $ticket->event->name }}</h3>

                    <div class="row g-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Nama Peserta</small>
                            <span class="fw-bold">{{ auth()->user()->full_name }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Waktu</small>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($ticket->event->date)->format('H:i') }} WIB</span>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Lokasi</small>
                            <span class="fw-bold"><i class="bi bi-geo-alt me-1"></i>{{ $ticket->event->location }}</span>
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-grid gap-2">
                        <a href="{{ route('user.tickets.print', $ticket->id) }}" target="_blank" class="btn btn-primary rounded-pill py-3 fw-bold">
                            <i class="bi bi-printer me-2"></i>Cetak / Simpan PDF
                        </a>
                        <a href="{{ route('my.tickets') }}" class="btn btn-outline-secondary rounded-pill py-3">
                            Kembali ke Daftar Tiket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection