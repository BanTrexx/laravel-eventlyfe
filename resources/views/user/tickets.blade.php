@extends('layouts.app')

@section('title', 'Tiket Saya - EventLyfe')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Tiket Saya</h2>
        <span class="badge bg-secondary rounded-pill px-3">{{ $tickets->count() }} Tiket</span>
    </div>

    <div class="row g-4">
        @forelse($tickets as $ticket)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-surface h-100">
                <div class="row g-0">
                    <div class="col-4">
                        @php
                        $url = file_exists(public_path('images/events/' . $ticket->event->image))
                        ? asset('images/events/' . $ticket->event->image)
                        : asset('storage/' . $ticket->event->image);
                        @endphp
                        <img src="{{ $url }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                    </div>

                    <div class="col-8">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0 text-truncate" style="max-width: 150px;">{{ $ticket->event->name }}</h5>

                                @if($ticket->status == 'pending')
                                <span class="badge bg-warning text-dark small">Pending</span>
                                @elseif($ticket->status == 'paid')
                                <span class="badge bg-success small">Terverifikasi</span>
                                @else
                                <span class="badge bg-danger small">Batal</span>
                                @endif
                            </div>

                            <p class="text-muted small mb-3">
                                <i class="bi bi-qr-code me-1"></i> {{ $ticket->ticket_code }}<br>
                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($ticket->event->date)->format('d M Y') }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>

                                @if($ticket->status == 'pending')
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $ticket->id }}">
                                    Upload Bukti
                                </button>
                                @elseif($ticket->status == 'paid')
                                <a href="{{ route('user.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    Lihat E-Tiket
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($ticket->status == 'pending')
        <div class="modal fade" id="uploadModal{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 bg-surface shadow">
                    <div class="modal-header border-0 p-4">
                        <h5 class="fw-bold mb-0">Upload Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('user.tickets.upload', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4 pt-0">
                            <p class="text-muted small">Silakan transfer ke rekening <strong>BCA 12345678 a/n EventLyfe</strong> sebesar <strong>Rp {{ number_format($ticket->price, 0, ',', '.') }}</strong></p>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Pilih Foto Bukti Transfer</label>
                                <input type="file" name="payment_proof" class="form-control bg-input-custom border-0" required accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, Max: 2MB</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Kirim Bukti Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-ticket-perforated text-muted opacity-25" style="font-size: 5rem;"></i>
            <p class="text-muted mt-3">Kamu belum memiliki tiket. Ayo cari event seru!</p>
            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">Eksplor Event</a>
        </div>
        @endforelse
    </div>
</div>
@endsection