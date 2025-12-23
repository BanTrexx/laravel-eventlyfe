<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Tiket - {{ $ticket->ticket_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --dark-text: #1a1a1a;
            --light-text: #6c757d;
        }

        body {
            background-color: #e9ecef;
            /* Warna background untuk preview di layar */
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* --- KONTAINER UTAMA A4 --- */
        .a4-ticket {
            width: 210mm;
            /* Lebar pas A4 */
            height: 297mm;
            /* Tinggi pas A4 */
            background: white;
            margin: 0 auto;
            /* Tengah di layar */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            /* Bayangan untuk preview di layar */
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        /* --- HEADER (Logo Berwarna & Background Putih) --- */
        .ticket-header {
            background: white;
            padding: 30px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--primary-color);
            /* Aksen biru di bawah */
        }

        .ticket-logo {
            height: 70px;
            /* Ukuran logo lebih besar untuk A4 */
            width: auto;
            /* Filter dihapus agar warna asli muncul */
        }

        .header-title {
            text-align: right;
        }

        .header-title h1 {
            font-weight: 800;
            font-size: 28px;
            color: var(--primary-color);
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* --- BODY (QR & Detail) --- */
        .ticket-body {
            flex: 1;
            /* Mengisi sisa ruang ke bawah */
            display: flex;
        }

        /* Sisi Kiri: QR Code */
        .qr-sidebar {
            width: 35%;
            /* Proporsi area QR */
            background-color: #f8f9fa;
            padding: 50px 30px;
            text-align: center;
            border-right: 3px dashed #dee2e6;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Pastikan warna background abu-abu tercetak */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .qr-box {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: inline-block;
        }

        .ticket-code-display {
            font-family: monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--dark-text);
            letter-spacing: 1px;
            display: block;
            margin-bottom: 10px;
        }

        /* Sisi Kanan: Detail Event */
        .info-main {
            flex: 1;
            padding: 50px;
        }

        .event-title {
            font-size: 36px;
            font-weight: 800;
            color: var(--dark-text);
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .event-location {
            font-size: 16px;
            color: var(--light-text);
            margin-bottom: 40px;
            display: flex;
            align-items: center;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        .detail-item .label {
            font-size: 12px;
            text-transform: uppercase;
            color: var(--light-text);
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .detail-item .value {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark-text);
        }

        /* --- FOOTER --- */
        .ticket-footer {
            padding: 20px 40px;
            text-align: center;
            font-size: 12px;
            color: var(--light-text);
            border-top: 1px solid #eee;
            background: #fff;
        }

        /* --- CSS KHUSUS PRINT --- */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
                /* PENTING: Margin 0 agar full A4 */
            }

            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .no-print {
                display: none !important;
            }

            .a4-ticket {
                box-shadow: none;
                margin: 0;
            }

            /* Memaksa browser mencetak background color & image */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>
    <div class="text-center no-print mb-4">
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
            <i class="bi bi-printer-fill me-2"></i>Cetak Tiket (A4)
        </button>
        <a href="{{ route('my.tickets') }}" class="btn btn-light rounded-pill px-4 py-2 ms-2 fw-bold">Kembali</a>
    </div>

    <div class="a4-ticket">
        <div class="ticket-header">
            <img src="{{ asset('images/eventlyfe_1.png') }}" alt="EventLyfe Logo" class="ticket-logo">

            <div class="header-title">
                <h1>E-Ticket Resmi</h1>
                <p class="mb-0 text-muted small">ID: #{{ str_replace('TKT-', '', $ticket->ticket_code) }}</p>
            </div>
        </div>

        <div class="ticket-body">
            <div class="qr-sidebar">
                <div class="qr-box">
                    {{-- Ukuran QR diperbesar agar proporsional di A4 --}}
                    {!! QrCode::size(200)->generate($ticket->ticket_code) !!}
                </div>
                <span class="ticket-code-display">{{ $ticket->ticket_code }}</span>
                <span class="badge bg-success fs-6 px-4 py-2 rounded-pill text-uppercase">Status: Lunas</span>
                <p class="mt-4 small text-muted">Tunjukkan QR Code ini kepada petugas di lokasi acara untuk dipindai.</p>
            </div>

            <div class="info-main">
                <h2 class="event-title">{{ $ticket->event->name }}</h2>
                <div class="event-location">
                    <i class="bi bi-geo-alt-fill text-primary me-2 fs-5"></i>
                    {{ $ticket->event->location }}
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="label">Nama Peserta</span>
                        <span class="value text-uppercase">{{ $ticket->user->full_name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Kategori Tiket</span>
                        {{-- Menggunakan optional() untuk jaga-jaga jika relasi category belum di-load --}}
                        <span class="value">{{ optional($ticket->event->category)->name ?? 'General' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tanggal Acara</span>
                        <span class="value">{{ \Carbon\Carbon::parse($ticket->event->date)->format('d F Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Waktu Mulai</span>
                        <span class="value">{{ \Carbon\Carbon::parse($ticket->event->date)->format('H:i') }} WIB</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Email Pemesan</span>
                        <span class="value small">{{ $ticket->user->email }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tanggal Pemesanan</span>
                        <span class="value small">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="ticket-footer">
            <p class="mb-1 fw-bold">SYARAT & KETENTUAN SINGKAT</p>
            <p class="mb-0">Tiket ini sah hanya untuk satu orang dan satu kali masuk. Dilarang menggandakan atau memindahtangankan tiket ini tanpa izin penyelenggara. Penyelenggara berhak menolak masuk jika tiket terindikasi palsu atau sudah digunakan. Simpan tiket ini baik-baik.</p>
            <p class="mt-3 mb-0 text-primary fw-bold">Powered by EventLyfe Ticketing System</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 800); // Jeda sedikit lebih lama (800ms) untuk memastikan layout A4 berat ter-render
        };
        window.onafterprint = function() {
            // Mengarahkan user kembali ke halaman daftar tiket
            // agar mereka tidak tertinggal di halaman print yang kosong
            window.location.href = "{{ route('my.tickets') }}";
        };
    </script>
</body>

</html>