@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('checker.dashboard') }}" class="btn btn-light rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Scanning: {{ $event->name }}</h4>
            <small class="text-muted">Arahkan kamera ke QR Code peserta</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="reader" class="overflow-hidden rounded-4 shadow-sm border-0"></div>

            <div class="card border-0 shadow-sm bg-surface rounded-4 mt-4 p-4 text-center">
                <div id="result-placeholder">
                    <i class="bi bi-camera fs-1 text-muted opacity-25"></i>
                    <p class="text-muted mt-2">Menunggu scan...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Berhenti scan sementara agar tidak mengirim request berkali-kali
        html5QrcodeScanner.clear();

        // Kirim data ke server via AJAX
        fetch("{{ route('checker.verify', $event->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ticket_code: decodedText
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Check-in Berhasil',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        restartScanner();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    }).then(() => {
                        restartScanner();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                restartScanner();
            });
    }

    function restartScanner() {
        html5QrcodeScanner.render(onScanSuccess);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>

<style>
    /* Styling agar scanner terlihat modern */
    #reader {
        border: none !important;
    }

    #reader__dashboard_section_csr button {
        background: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
    }

    video {
        border-radius: 15px;
    }
</style>
@endsection