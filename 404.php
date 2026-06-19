<?php
include "config/koneksi.php";
$page_title = '404 — Halaman Tidak Ditemukan | NewsPortal';
include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container" style="padding:80px 16px; text-align:center; min-height:60vh; display:flex; align-items:center; justify-content:center;">
    <div>
        <div style="font-size:100px; font-weight:800; color:var(--red); line-height:1;">404</div>
        <h2 style="font-weight:800; color:var(--dark); margin:16px 0 12px;">Halaman Tidak Ditemukan</h2>
        <p style="color:var(--gray); font-size:15px; max-width:420px; margin:0 auto 32px; line-height:1.8;">
            Halaman yang kamu cari tidak tersedia, sudah dipindahkan, atau mungkin URL-nya salah.
        </p>
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
            <a href="/newsportal/index.php" class="btn-primary-red">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
            <a href="/newsportal/kategori.php" class="btn-outline-red">
                <i class="bi bi-newspaper"></i> Lihat Semua Berita
            </a>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
