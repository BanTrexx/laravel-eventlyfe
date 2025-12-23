@extends('layouts.app')

@section('title', 'Manajemen Checker - EventLyfe')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Manajemen Tim Checker</h2>
            <p class="text-muted">Kelola akun staf yang bertugas melakukan scanning tiket.</p>
        </div>
        <button class="btn btn-primary px-4 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#addCheckerModal">
            <i class="bi bi-person-plus me-2"></i>Tambah Checker Baru
        </button>
    </div>

    <div class="card border-0 shadow-sm bg-surface rounded-4">
        <div class="card-header bg-transparent border-0 p-4">
            <h4 class="fw-bold mb-0">Daftar Checker Anda</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tanggal Bergabung</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($checkers as $checker)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary bg-opacity-10 p-2 rounded-circle me-3">
                                        <i class="bi bi-person text-secondary"></i>
                                    </div>
                                    <span class="fw-bold">{{ $checker->full_name }}</span>
                                </div>
                            </td>
                            <td><span class="text-primary">@</span>{{ $checker->username }}</td>
                            <td>{{ $checker->email }}</td>
                            <td>{{ $checker->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('organizer.checkers.destroy', $checker->id) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-event">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-people text-muted opacity-25" style="font-size: 5rem;"></i>
                                </div>
                                <p class="text-muted fw-medium">Belum ada checker terdaftar</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCheckerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-surface border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold">Buat Akun Checker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('organizer.checkers.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control bg-input-custom border-0" placeholder="Nama staf" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Username</label>
                        <input type="text" name="username" class="form-control bg-input-custom border-0" placeholder="username_staf" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email</label>
                        <input type="email" name="email" class="form-control bg-input-custom border-0" placeholder="staf@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Password</label>
                        <input type="password" name="password" class="form-control bg-input-custom border-0" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Simpan Akun Checker</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection