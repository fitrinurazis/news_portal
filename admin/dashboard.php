<?php
include "header.php";

// Hanya ketua yang boleh akses
if ($_SESSION['role'] != 'ketua') {
    header("Location: /newsportal/admin/index.php");
    exit;
}

include "sidebar.php";

// Hitung statistik
$total_artikel  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM artikel"))['total'] ?? 0;
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'] ?? 0;
$total_user     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users"))['total'] ?? 0;
$total_komentar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM komentar"))['total'] ?? 0;
?>

<div class="col-md-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-shield-check me-2 text-warning"></i>Dashboard Ketua
        </h5>
        <a href="/newsportal/index.php" target="_blank" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-eye me-1"></i>Lihat Website
        </a>
    </div>

    <div class="p-4">
        <!-- Selamat Datang -->
        <div class="alert alert-warning d-flex align-items-center mb-4">
            <i class="bi bi-person-badge fs-4 me-3"></i>
            <div>
                Selamat datang, <strong><?= $_SESSION['nama'] ?></strong>!
                Anda memiliki akses penuh sebagai <strong>Ketua</strong>.
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?= $total_artikel ?></h2>
                            <p class="mb-0 small">Total Artikel</p>
                        </div>
                        <i class="bi bi-newspaper fs-1 opacity-50"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="/newsportal/admin/artikel/index.php" class="text-white-50 small text-decoration-none">
                            Kelola Artikel <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?= $total_kategori ?></h2>
                            <p class="mb-0 small">Total Kategori</p>
                        </div>
                        <i class="bi bi-tags fs-1 opacity-50"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="/newsportal/admin/kategori/index.php" class="text-white-50 small text-decoration-none">
                            Kelola Kategori <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?= $total_user ?></h2>
                            <p class="mb-0 small">Total User</p>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="/newsportal/admin/user.php" class="text-dark-50 small text-decoration-none">
                            Kelola User <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?= $total_komentar ?></h2>
                            <p class="mb-0 small">Total Komentar</p>
                        </div>
                        <i class="bi bi-chat-dots fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">
                <i class="bi bi-lightning-charge me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <a href="/newsportal/admin/user.php" class="btn btn-outline-warning me-2 mb-2">
                    <i class="bi bi-people me-1"></i>Kelola User
                </a>
                <a href="/newsportal/admin/kategori/tambah.php" class="btn btn-outline-success me-2 mb-2">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
                </a>
                <a href="/newsportal/admin/artikel/tambah.php" class="btn btn-outline-primary me-2 mb-2">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Artikel
                </a>
                <a href="/newsportal/admin/artikel/index.php" class="btn btn-outline-secondary me-2 mb-2">
                    <i class="bi bi-list-ul me-1"></i>Semua Artikel
                </a>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
