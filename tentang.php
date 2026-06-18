<?php
include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container mt-4 mb-5">

    <!-- Hero Tentang -->
    <div class="p-5 mb-4 bg-dark text-white rounded-3 text-center">
        <i class="bi bi-newspaper" style="font-size: 3rem;"></i>
        <h1 class="fw-bold mt-3">Tentang News Portal</h1>
        <p class="col-md-8 mx-auto fs-5 text-secondary mt-2">
            Portal berita terpercaya yang menyajikan informasi terbaru, akurat, dan terkini.
        </p>
    </div>

    <div class="row">
        <!-- Visi Misi -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded p-2 me-3">
                            <i class="bi bi-eye fs-4"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Visi</h4>
                    </div>
                    <p class="text-muted">
                        Menjadi portal berita digital terpercaya yang mengedepankan
                        akurasi, objektivitas, dan kecepatan dalam penyampaian informasi
                        kepada masyarakat luas.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success text-white rounded p-2 me-3">
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Misi</h4>
                    </div>
                    <ul class="text-muted ps-3 mb-0">
                        <li class="mb-2">Menyajikan berita yang akurat dan terverifikasi</li>
                        <li class="mb-2">Memberikan informasi yang bermanfaat bagi masyarakat</li>
                        <li class="mb-2">Menjaga independensi dan objektivitas jurnalistik</li>
                        <li>Menghadirkan konten edukatif dan informatif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Keunggulan -->
    <div class="row text-center mt-2 mb-4">
        <div class="col-12 mb-4">
            <h3 class="fw-bold">Mengapa News Portal?</h3>
            <p class="text-muted">Kami berkomitmen untuk menjadi sumber berita terpercaya</p>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <i class="bi bi-lightning-charge text-warning" style="font-size: 2rem;"></i>
                <h6 class="fw-bold mt-2">Cepat & Terkini</h6>
                <p class="text-muted small mb-0">Berita terbaru selalu tersedia secara real-time</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                <h6 class="fw-bold mt-2">Terpercaya</h6>
                <p class="text-muted small mb-0">Setiap berita terverifikasi oleh tim redaksi kami</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <i class="bi bi-phone text-primary" style="font-size: 2rem;"></i>
                <h6 class="fw-bold mt-2">Responsif</h6>
                <p class="text-muted small mb-0">Tampilan optimal di semua perangkat</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <i class="bi bi-tags text-danger" style="font-size: 2rem;"></i>
                <h6 class="fw-bold mt-2">Multi Kategori</h6>
                <p class="text-muted small mb-0">Beragam topik dari teknologi hingga olahraga</p>
            </div>
        </div>
    </div>

    <!-- Kontak -->
    <div class="card border-0 bg-dark text-white p-4 rounded-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-1">Hubungi Kami</h4>
                <p class="text-secondary mb-0">Punya pertanyaan atau ingin bekerja sama? Kami siap membantu.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="mailto:redaksi@newsportal.com" class="btn btn-warning fw-bold">
                    <i class="bi bi-envelope me-2"></i>Email Kami
                </a>
            </div>
        </div>
    </div>

</div>

<?php include "includes/footer.php"; ?>
