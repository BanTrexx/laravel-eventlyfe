@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm bg-surface rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Edit Event: {{ $event->name }}</h3>

                    <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-4 text-center">
                            <label class="d-block mb-2 fw-bold text-start">Poster Saat Ini</label>
                            <img src="{{ asset('storage/' . $event->image) }}" class="rounded-3 shadow-sm mb-3" style="max-height: 200px; width: auto;">
                            <input type="file" name="image" class="form-control bg-input-custom border-0">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah poster</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Event</label>
                            <input type="text" name="name" class="form-control bg-input-custom border-0" value="{{ old('name', $event->name) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category_id" class="form-select bg-input-custom border-0">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" name="location" class="form-control bg-input-custom border-0" value="{{ old('location', $event->location) }}">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal & Jam Mulai</label>
                                <input type="datetime-local" name="date" class="form-control bg-input-custom border-0" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga Tiket</label>
                                <input type="number" name="price" class="form-control bg-input-custom border-0" value="{{ $event->price }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kuota Tiket</label>
                            <input type="number" name="quota" class="form-control bg-input-custom border-0" value="{{ $event->quota }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Event</label>
                            <textarea name="description" rows="5" class="form-control bg-input-custom border-0">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Simpan Perubahan</button>
                            <a href="{{ route('organizer.dashboard') }}" class="btn btn-link text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection