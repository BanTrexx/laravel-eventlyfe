@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm bg-surface rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-4">Detail Pesanan</h4>
                <div class="d-flex align-items-start gap-4">
                    @php
                    $url = file_exists(public_path('images/events/' . $event->image))
                    ? asset('images/events/' . $event->image)
                    : asset('storage/' . $event->image);
                    @endphp
                    <img src="{{ $url }}" class="rounded-4 shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                    <div>
                        <span class="badge bg-primary mb-2">{{ $event->category->name }}</span>
                        <h3 class="fw-bold mb-1">{{ $event->name }}</h3>
                        <p class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}<br>
                            <i class="bi bi-geo-alt me-1"></i> {{ $event->location }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-surface rounded-4 p-4 sticky-top" style="top: 2rem;">
                <h5 class="fw-bold mb-4">Ringkasan Pembayaran</h5>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Jumlah Tiket</label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary border-0 bg-input-custom" type="button" onclick="updateQty(-1)">-</button>
                            <input type="number" name="quantity" id="qtyInput" class="form-control bg-input-custom border-0 text-center fw-bold" value="1" min="1" max="{{ $event->quota }}" readonly>
                            <button class="btn btn-outline-secondary border-0 bg-input-custom" type="button" onclick="updateQty(1)">+</button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-5 fw-bold text-primary" id="totalDisplay">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">
                        Konfirmasi Pemesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var price = Number("{{ $event->price }}" ?? 0);
    var maxQuota = Number("{{ $event->quota }}" ?? 0);

    function updateQty(change) {
        var input = document.getElementById('qtyInput');
        var display = document.getElementById('totalDisplay');
        var current = parseInt(input.value);

        current += change;

        if (current >= 1 && current <= maxQuota) {
            input.value = current;
            var total = current * price;
            // Format Rupiah di JavaScript
            display.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    }
</script>
@endsection