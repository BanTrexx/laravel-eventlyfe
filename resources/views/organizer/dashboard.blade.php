@extends('layouts.app')

@section('title', 'Organizer Dashboard - EventLyfe')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Dashboard Organizer</h2>
            <p class="text-muted">Selamat datang kembali, {{ auth()->user()->full_name }}!</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('organizer.verifications') }}" class="btn btn-warning px-4 rounded-pill fw-bold text-dark shadow-sm">
                <i class="bi bi-patch-check me-2"></i>Verifikasi Pembayaran
            </a>
            <a href="{{ route('organizer.checkers.index') }}" class="btn btn-outline-primary px-4 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-people me-2"></i>Kelola Checker
            </a>
            <a href="{{ route('organizer.events.create') }}" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Buat Event
            </a>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-surface h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-calendar-event text-primary fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">Total Event</h6>
                        <h3 class="fw-bold mb-0">{{ $events->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-surface h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-people text-info fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">Tim Checker</h6>
                        <h3 class="fw-bold mb-0">{{ $total_checkers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-surface h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-ticket-perforated text-success fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">Tiket Terjual</h6>
                        <h3 class="fw-bold mb-0">{{ $total_tickets }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <a href="{{ route('organizer.verifications') }}" class="text-decoration-none h-100">
                <div class="card border-0 shadow-sm p-3 bg-surface h-100 border-start border-warning border-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="bi bi-cash-stack text-warning fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold">Perlu Verifikasi</h6>
                            <h3 class="fw-bold mb-0">{{ $pending_payments }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-surface rounded-4">
        <div class="card-header bg-transparent border-0 p-4">
            <h4 class="fw-bold mb-0">Manajemen Event Anda</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Nama Event</th>
                            <th>Tanggal</th>
                            <th>Harga</th>
                            <th>Kuota</th>
                            <th>Peserta</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @php
                                    $url = Storage::disk('public')->exists($event->image)
                                    ? asset('storage/' . $event->image)
                                    : asset('images/events/' . $event->image);
                                    @endphp
                                    <img src="{{ $url }}" class="rounded-3 me-3" width="50" height="50" style="object-fit: cover;">
                                    <span class="fw-bold">{{ $event->name }}</span>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                            <td>{{ $event->quota }}</td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $event->tickets_count }} Terisi</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#assignModal{{ $event->id }}" title="Tugaskan Checker">
                                        <i class="bi bi-people"></i>
                                    </button>
                                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Event">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-event" title="Hapus Event">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="assignModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-surface border-0 shadow-lg">
                                    <div class="modal-header border-0 p-4">
                                        <h5 class="fw-bold mb-0">Tugaskan Checker: {{ $event->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('organizer.events.assign', $event->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body p-4 pt-0">
                                            <p class="text-muted small mb-3">Pilih staf yang akan bertugas di event ini:</p>
                                            @php
                                            $myCheckers = \App\Models\User::where('organizer_id', auth()->id())
                                            ->whereHas('role', fn($q) => $q->where('slug', 'checker'))
                                            ->get();
                                            $assignedIds = $event->checkers->pluck('id')->toArray();
                                            @endphp
                                            <div class="list-group border-0">
                                                @forelse($myCheckers as $checker)
                                                <label class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0 py-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-person-circle me-3 text-muted fs-4"></i>
                                                        <div>
                                                            <div class="fw-bold text-auth-header small">{{ $checker->full_name }}</div>
                                                            <div class="small text-muted">@ {{ $checker->username }}</div>
                                                        </div>
                                                    </div>
                                                    <input class="form-check-input" type="checkbox" name="checker_ids[]" value="{{ $checker->id }}" {{ in_array($checker->id, $assignedIds) ? 'checked' : '' }}>
                                                </label>
                                                @empty
                                                <div class="text-center py-3">
                                                    <p class="text-muted small">Belum ada checker. Silakan <a href="{{ route('organizer.checkers.index') }}">tambah tim</a> dulu.</p>
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Update Tim Petugas</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="text-muted fw-medium">Belum ada event ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.btn-delete-event');
        if (deleteButton) {
            e.preventDefault();
            const form = deleteButton.closest('form');
            Swal.fire({
                title: 'Hapus Event?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: document.body.classList.contains('dark-mode') ? '#2d2d2d' : '#fff',
                color: document.body.classList.contains('dark-mode') ? '#fff' : '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
</script>
@endsection