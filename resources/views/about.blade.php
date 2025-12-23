@extends('layouts.app')

@section('title', 'Tentang Kami - EventLyfe')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, var(--bg-surface) 0%, var(--bg-body) 100%); margin-top: -20px;">
    <div class="container py-5 mt-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h6 class="text-primary fw-bold text-uppercase mb-3">Siapa Kami?</h6>
                <h1 class="display-4 fw-bold mb-4">Menghubungkan Anda dengan <span class="text-primary">Momen Tak Terlupakan.</span></h1>
                <p class="lead text-muted mb-4">
                    EventLyfe bukan sekadar platform tiket. Kami adalah jembatan aspirasi bagi kreator event dan pintu gerbang kebahagiaan bagi para penikmat hiburan.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/icon.png') }}" alt="EventLyfe Vision" class="img-fluid" style="max-height: 350px;">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white shadow-sm border-top border-bottom bg-surface">
    <div class="container py-4">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold">Cerita Kami</h2>
                <div class="mx-auto bg-primary rounded" style="width: 60px; height: 4px;"></div>
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-md-5">
                <div class="p-4 rounded-4 bg-primary bg-opacity-10 text-center">
                    <h3 class="display-1 fw-bold text-primary">2025</h3>
                    <p class="fw-bold text-dark">Tahun Perjalanan Dimulai</p>
                </div>
            </div>
            <div class="col-md-7">
                <p class="fs-5 text-secondary">
                    Didirikan pada tahun <strong>2025</strong>, EventLyfe lahir dari tangan dingin <strong>3 Mahasiswa berbakat Telkom University Jakarta</strong> dari program studi <strong>S1 Teknologi Informasi</strong>.
                </p>
                <p class="text-muted">
                    Berawal dari tugas akhir yang penuh ambisi, mereka melihat adanya kesenjangan antara kemudahan teknologi dan aksesibilitas event lokal. Dengan semangat inovasi dan latar belakang IT yang kuat, mereka mengembangkan platform ticketing yang aman, cepat, dan transparan bagi masyarakat Indonesia.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 event-card h-100">
                    <h4 class="fw-bold mb-4">Kontak Kami</h4>
                    <div class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill text-primary fs-4 me-3"></i>
                        <p class="text-muted">Jl. Kemang Dalam IV no K24, Bangka, Kemang, Jakarta Selatan</p>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-envelope-fill text-primary fs-4 me-3"></i>
                        <p class="text-muted">hello@eventlyfe.com</p>
                    </div>
                    <div class="d-flex">
                        <i class="bi bi-telephone-fill text-primary fs-4 me-3"></i>
                        <p class="text-muted">+62 21-8888-9999</p>
                    </div>
                    <hr>
                    <p class="small text-muted mb-0">Terletak strategis di jantung industri kreatif Jakarta Selatan, kami selalu terbuka untuk kolaborasi hebat.</p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-4 shadow-sm h-100 border bg-surface">
                            <i class="bi bi-shield-check text-success fs-1 mb-3"></i>
                            <h5 class="fw-bold">Keamanan Terjamin</h5>
                            <p class="text-muted small">Setiap tiket dilengkapi dengan QR Code unik yang terenkripsi untuk mencegah duplikasi.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-4 shadow-sm h-100 border bg-surface">
                            <i class="bi bi-lightning-charge-fill text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold">Inovasi Mahasiswa</h5>
                            <p class="text-muted small">Dikembangkan dengan teknologi terbaru oleh talenta IT terbaik dari Telkom University Jakarta.</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="rounded-4 overflow-hidden shadow-sm position-relative" style="height: 250px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0886567527196!2d106.8123281748286!3d-6.252044993736566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f16611f7743d%3A0xc6657c7c3b99b04d!2sJl.%20Kemang%20Dalam%20IV%2C%20RT.6%2FRW.3%2C%20Bangka%2C%20Kec.%20Mampang%20Prpt.%2C%20Kota%20Jakarta%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection