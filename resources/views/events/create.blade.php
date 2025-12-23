@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm bg-surface rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Buat Event Baru</h3>

                    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Poster Event</label>
                            <input type="file" name="image" class="form-control bg-input-custom border-0 @error('image') is-invalid @enderror">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Event</label>
                            <input type="text" name="name" class="form-control bg-input-custom border-0" placeholder="Contoh: Konser Jazz Malam">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori Event</label>
                            <select name="category_id" class="form-select bg-input-custom border-0 @error('category_id') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi / Venue</label>
                            <div class="input-group">
                                <span class="input-group-text bg-input-custom border-0"><i class="bi bi-geo-alt text-muted"></i></span>
                                <input type="text" name="location" class="form-control bg-input-custom border-0 @error('location') is-invalid @enderror"
                                    value="{{ old('location') }}" required placeholder="Contoh: Jakarta International Stadium atau Online via Zoom">
                            </div>
                            @error('location') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal & Jam Mulai</label>
                                <input type="datetime-local" name="date" class="form-control bg-input-custom border-0 @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga Tiket (Rp)</label>
                                <input type="number" name="price" class="form-control bg-input-custom border-0" placeholder="0 untuk gratis">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kuota Tiket</label>
                            <input type="number" name="quota" class="form-control bg-input-custom border-0">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Event</label>
                            <textarea name="description" rows="5" class="form-control bg-input-custom border-0"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Simpan Event</button>
                            <a href="{{ route('organizer.dashboard') }}" class="btn btn-link text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection