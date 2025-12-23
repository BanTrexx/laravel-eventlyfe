@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Verifikasi Pembayaran</h2>
        <p class="text-muted">Cek bukti transfer dan aktifkan tiket peserta.</p>
    </div>

    <div class="card border-0 shadow-sm bg-surface rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Pembeli</th>
                            <th>Event</th>
                            <th>Total Bayar</th>
                            <th>Bukti Transfer</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingTickets as $ticket)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold">{{ $ticket->user->full_name }}</span><br>
                                <small class="text-muted">{{ $ticket->user->email }}</small>
                            </td>
                            <td>{{ $ticket->event->name }}</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info rounded-pill" data-bs-toggle="modal" data-bs-target="#viewProof{{ $ticket->id }}">
                                    <i class="bi bi-image me-1"></i> Lihat Bukti
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('organizer.tickets.approve', $ticket->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Terima</button>
                                    </form>
                                    <form action="{{ route('organizer.tickets.reject', $ticket->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="viewProof{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-surface border-0 shadow">
                                    <div class="modal-header border-0">
                                        <h5 class="fw-bold">Bukti Transfer: {{ $ticket->user->full_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0 text-center bg-dark">
                                        <img src="{{ asset('storage/' . $ticket->payment_proof) }}" class="img-fluid">
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                                Tidak ada pembayaran yang perlu diverifikasi saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection