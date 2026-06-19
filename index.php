<?php
include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";

// Hero artikel (terbaru)
$hero = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     ORDER BY artikel.id DESC LIMIT 1"
));

// Artikel untuk side hero (4 berikutnya)
$side_articles = mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     ORDER BY artikel.id DESC LIMIT 4 OFFSET 1"
);

// Berita terbaru (6 setelahnya)
$terbaru = mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     ORDER BY artikel.id DESC LIMIT 6 OFFSET 5"
);

// Kategori yang punya artikel
$kategori_list = mysqli_query($koneksi,
    "SELECT DISTINCT kategori.*
     FROM kategori
     INNER JOIN artikel ON artikel.kategori_id = kategori.id
     ORDER BY kategori.nama_kategori ASC"
);
?>

<div class="container mt-4">

<?php if ($hero): ?>
<!-- ====== HERO SECTION ====== -->
<div class="row g-3 mb-5">

    <!-- Main Hero -->
    <div class="col-lg-7">
        <a href="/newsportal/detail.php?id=<?= $hero['id'] ?>">
            <div class="hero-card">
                <?php if ($hero['thumbnail']): ?>
                    <img src="/newsportal/uploads/<?= $hero['thumbnail'] ?>"
                         alt="<?= htmlspecialchars($hero['judul']) ?>">
                <?php else: ?>
                    <img src="https://picsum.photos/seed/<?= $hero['id'] ?>/800/440" alt="hero">
                <?php endif; ?>
                <div class="hero-overlay">
                    <span class="cat-badge"><?= htmlspecialchars($hero['nama_kategori'] ?? 'Umum') ?></span>
                    <div class="hero-title"><?= htmlspecialchars($hero['judul']) ?></div>
                    <div class="hero-meta">
                        <i class="bi bi-person me-1"></i><?= htmlspecialchars($hero['nama_penulis'] ?? 'Admin') ?>
                        &nbsp;&bull;&nbsp;
                        <i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($hero['tanggal'])) ?>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Side Articles -->
    <div class="col-lg-5">
        <div class="row g-3 h-100">
            <?php while ($s = mysqli_fetch_assoc($side_articles)): ?>
            <div class="col-6">
                <a href="/newsportal/detail.php?id=<?= $s['id'] ?>" style="display:block; height:100%;">
                    <div class="news-card" style="height:100%;">
                        <?php if ($s['thumbnail']): ?>
                            <img class="card-img" src="/newsportal/uploads/<?= $s['thumbnail'] ?>"
                                 alt="<?= htmlspecialchars($s['judul']) ?>">
                        <?php else: ?>
                            <div class="card-img-placeholder"><i class="bi bi-image"></i></div>
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="cat-badge" style="font-size:9px;">
                                <?= htmlspecialchars($s['nama_kategori'] ?? 'Umum') ?>
                            </span>
                            <div class="card-title"><?= htmlspecialchars($s['judul']) ?></div>
                            <div class="card-meta">
                                <span><i class="bi bi-clock"></i><?= date('d M Y', strtotime($s['tanggal'])) ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ====== BERITA TERBARU ====== -->
<?php if (mysqli_num_rows($terbaru) > 0): ?>
<div class="mt-section mb-5">
    <div class="section-header">
        <div class="section-title">Berita Terbaru</div>
        <a href="/newsportal/kategori.php" class="see-all">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="row g-3">
        <?php while ($art = mysqli_fetch_assoc($terbaru)): ?>
        <div class="col-md-4 col-sm-6">
            <a href="/newsportal/detail.php?id=<?= $art['id'] ?>" style="display:block; height:100%;">
                <div class="news-card">
                    <?php if ($art['thumbnail']): ?>
                        <img class="card-img" src="/newsportal/uploads/<?= $art['thumbnail'] ?>"
                             alt="<?= htmlspecialchars($art['judul']) ?>">
                    <?php else: ?>
                        <div class="card-img-placeholder"><i class="bi bi-image"></i></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="cat-badge"><?= htmlspecialchars($art['nama_kategori'] ?? 'Umum') ?></span>
                        <div class="card-title"><?= htmlspecialchars($art['judul']) ?></div>
                        <div class="card-excerpt">
                            <?= mb_strimwidth(strip_tags($art['isi_berita']), 0, 90, '...') ?>
                        </div>
                        <div class="card-meta">
                            <span><i class="bi bi-person"></i><?= htmlspecialchars($art['nama_penulis'] ?? 'Admin') ?></span>
                            <span><i class="bi bi-clock"></i><?= date('d M Y', strtotime($art['tanggal'])) ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>

<!-- ====== BERITA PER KATEGORI ====== -->
<?php
mysqli_data_seek($kategori_list, 0);
while ($kat = mysqli_fetch_assoc($kategori_list)):
    $arts = mysqli_query($koneksi,
        "SELECT artikel.*, users.nama AS nama_penulis
         FROM artikel
         LEFT JOIN users ON artikel.user_id = users.id
         WHERE artikel.kategori_id = '{$kat['id']}'
         ORDER BY artikel.id DESC LIMIT 4"
    );
    if (mysqli_num_rows($arts) == 0) continue;

    $first = mysqli_fetch_assoc($arts);
?>
<div class="mt-section mb-5">
    <div class="section-header">
        <div class="section-title"><?= htmlspecialchars($kat['nama_kategori']) ?></div>
        <a href="/newsportal/kategori.php?id=<?= $kat['id'] ?>" class="see-all">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="row g-3">
        <!-- Artikel utama kategori (kiri, lebih besar) -->
        <div class="col-md-5">
            <a href="/newsportal/detail.php?id=<?= $first['id'] ?>" style="display:block; height:100%;">
                <div class="news-card" style="height:100%;">
                    <?php if ($first['thumbnail']): ?>
                        <img class="card-img" src="/newsportal/uploads/<?= $first['thumbnail'] ?>"
                             alt="<?= htmlspecialchars($first['judul']) ?>"
                             style="height:240px;">
                    <?php else: ?>
                        <div class="card-img-placeholder" style="height:240px;"><i class="bi bi-image"></i></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="cat-badge"><?= htmlspecialchars($kat['nama_kategori']) ?></span>
                        <div class="card-title" style="font-size:16px; -webkit-line-clamp:2;">
                            <?= htmlspecialchars($first['judul']) ?>
                        </div>
                        <div class="card-excerpt">
                            <?= mb_strimwidth(strip_tags($first['isi_berita']), 0, 110, '...') ?>
                        </div>
                        <div class="card-meta">
                            <span><i class="bi bi-person"></i><?= htmlspecialchars($first['nama_penulis'] ?? 'Admin') ?></span>
                            <span><i class="bi bi-clock"></i><?= date('d M Y', strtotime($first['tanggal'])) ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Artikel lainnya (kanan, list) -->
        <div class="col-md-7">
            <div class="d-flex flex-column gap-3 h-100">
                <?php while ($a = mysqli_fetch_assoc($arts)): ?>
                <a href="/newsportal/detail.php?id=<?= $a['id'] ?>" style="flex:1;">
                    <div class="small-card" style="height:100%;">
                        <?php if ($a['thumbnail']): ?>
                            <img class="small-img" src="/newsportal/uploads/<?= $a['thumbnail'] ?>"
                                 alt="<?= htmlspecialchars($a['judul']) ?>">
                        <?php else: ?>
                            <div class="small-img-placeholder"><i class="bi bi-image" style="color:#cbd5e1;"></i></div>
                        <?php endif; ?>
                        <div class="small-body">
                            <div class="small-title"><?= htmlspecialchars($a['judul']) ?></div>
                            <div class="small-meta">
                                <i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($a['tanggal'])) ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

<!-- Jika belum ada artikel sama sekali -->
<?php if (!$hero): ?>
<div class="text-center py-5">
    <i class="bi bi-newspaper" style="font-size:4rem; color:#cbd5e1;"></i>
    <h4 class="mt-3" style="color:var(--gray);">Belum ada artikel</h4>
    <p style="color:var(--gray);">Mulai tambahkan artikel melalui panel admin.</p>
    <a href="/newsportal/auth/login.php" class="btn-primary-red mt-2">Masuk ke Admin</a>
</div>
<?php endif; ?>

</div><!-- /container -->

<?php include "includes/footer.php"; ?>
