<?php
include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";

// Query hero news (1 artikel terbaru)
$hero = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     ORDER BY artikel.id DESC
     LIMIT 1"
));

// Query semua kategori yang memiliki artikel
$data_kategori = mysqli_query($koneksi,
    "SELECT DISTINCT kategori.*
     FROM kategori
     INNER JOIN artikel ON artikel.kategori_id = kategori.id
     ORDER BY kategori.nama_kategori ASC"
);
?>

<div class="container mt-4">

    <?php if ($hero): ?>
    <!-- HERO NEWS -->
    <div class="row mb-5">
        <div class="col-12">
            <p class="section-heading">Berita Utama</p>
        </div>
        <div class="col-12">
            <div class="hero-news shadow">
                <?php if ($hero['thumbnail']): ?>
                    <img src="/newsportal/uploads/<?= $hero['thumbnail'] ?>" alt="<?= htmlspecialchars($hero['judul']) ?>">
                <?php else: ?>
                    <img src="https://picsum.photos/seed/hero/1200/420" alt="Hero">
                <?php endif; ?>

                <div class="hero-overlay">
                    <span class="badge bg-warning text-dark badge-kategori mb-2">
                        <?= htmlspecialchars($hero['nama_kategori'] ?? 'Umum') ?>
                    </span>
                    <h2>
                        <a href="/newsportal/detail.php?id=<?= $hero['id'] ?>">
                            <?= htmlspecialchars($hero['judul']) ?>
                        </a>
                    </h2>
                    <small>
                        <i class="bi bi-person-fill me-1"></i><?= htmlspecialchars($hero['nama_penulis'] ?? 'Admin') ?>
                        &nbsp;&bull;&nbsp;
                        <i class="bi bi-clock me-1"></i><?= date('d F Y', strtotime($hero['tanggal'])) ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- BERITA PER KATEGORI -->
    <?php
    mysqli_data_seek($data_kategori, 0);
    while ($kat = mysqli_fetch_assoc($data_kategori)):
        $artikel_kat = mysqli_query($koneksi,
            "SELECT artikel.*, users.nama AS nama_penulis
             FROM artikel
             LEFT JOIN users ON artikel.user_id = users.id
             WHERE artikel.kategori_id = '{$kat['id']}'
             ORDER BY artikel.id DESC
             LIMIT 3"
        );
        if (mysqli_num_rows($artikel_kat) == 0) continue;
    ?>
    <div class="row mb-5">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <p class="section-heading mb-0"><?= htmlspecialchars($kat['nama_kategori']) ?></p>
            <a href="/newsportal/kategori.php?id=<?= $kat['id'] ?>" class="btn btn-sm btn-outline-primary">
                Lihat Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <?php while ($art = mysqli_fetch_assoc($artikel_kat)): ?>
        <div class="col-md-4 mb-4">
            <div class="card card-artikel shadow-sm">
                <?php if ($art['thumbnail']): ?>
                    <img src="/newsportal/uploads/<?= $art['thumbnail'] ?>" alt="<?= htmlspecialchars($art['judul']) ?>">
                <?php else: ?>
                    <div class="no-image"><i class="bi bi-image"></i></div>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <a href="/newsportal/detail.php?id=<?= $art['id'] ?>">
                            <?= htmlspecialchars($art['judul']) ?>
                        </a>
                    </h5>
                    <p class="card-text text-muted small flex-grow-1">
                        <?= mb_strimwidth(strip_tags($art['isi_berita']), 0, 100, '...') ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i><?= htmlspecialchars($art['nama_penulis'] ?? 'Admin') ?>
                        </small>
                        <small class="text-muted">
                            <?= date('d M Y', strtotime($art['tanggal'])) ?>
                        </small>
                    </div>
                    <a href="/newsportal/detail.php?id=<?= $art['id'] ?>" class="btn btn-primary btn-sm mt-3">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <hr class="mb-5">
    <?php endwhile; ?>

    <?php if (!$hero): ?>
    <!-- Tampilan jika belum ada artikel -->
    <div class="text-center py-5">
        <i class="bi bi-newspaper" style="font-size: 4rem; color: #dee2e6;"></i>
        <h4 class="mt-3 text-muted">Belum ada artikel</h4>
        <p class="text-muted">Silakan tambahkan artikel melalui halaman admin.</p>
        <a href="/newsportal/auth/login.php" class="btn btn-primary">Masuk ke Admin</a>
    </div>
    <?php endif; ?>

</div>

<?php include "includes/footer.php"; ?>
