<?php
include "config/koneksi.php";

$id = (int) ($_GET['id'] ?? 0);

// PRG: simpan komentar sebelum output HTML
if (isset($_POST['kirim'])) {
    $nama        = htmlspecialchars(trim($_POST['nama']));
    $email       = htmlspecialchars(trim($_POST['email']));
    $isiKomentar = htmlspecialchars(trim($_POST['komentar']));
    if ($nama && $email && $isiKomentar) {
        mysqli_query($koneksi,
            "INSERT INTO komentar (artikel_id, nama, email, komentar)
             VALUES ('$id', '$nama', '$email', '$isiKomentar')"
        );
        header("Location: /newsportal/detail.php?id=$id&komentar=sukses");
        exit;
    }
}

include "includes/header.php";
include "includes/navbar.php";

$artikel = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     WHERE artikel.id = '$id' LIMIT 1"
));

if (!$artikel) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Artikel tidak ditemukan.</div></div>';
    include "includes/footer.php";
    exit;
}

$read_time   = max(1, round(str_word_count(strip_tags($artikel['isi_berita'])) / 200));
$komentar    = mysqli_query($koneksi, "SELECT * FROM komentar WHERE artikel_id='$id' ORDER BY id DESC");
$jml_komen   = mysqli_num_rows($komentar);
$terkait     = mysqli_query($koneksi,
    "SELECT * FROM artikel WHERE kategori_id='{$artikel['kategori_id']}' AND id!='$id' ORDER BY id DESC LIMIT 3"
);
$semua_kat   = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
$art_populer = mysqli_query($koneksi, "SELECT id, judul, thumbnail, tanggal FROM artikel ORDER BY id DESC LIMIT 5");
?>

<!-- Reading Progress Bar -->
<div id="read-progress"></div>

<div class="container" style="padding-top: 32px; padding-bottom: 60px;">
<div class="row g-4">

    <!-- ====== KONTEN ARTIKEL ====== -->
    <div class="col-lg-8">
        <div class="article-card-pad" style="background:var(--white); border-radius:var(--radius); box-shadow:var(--shadow-sm);">

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="/newsportal/index.php">Home</a></li>
                <li class="sep"><i class="bi bi-chevron-right" style="font-size:10px;"></i></li>
                <li>
                    <a href="/newsportal/kategori.php?id=<?= $artikel['kategori_id'] ?>">
                        <?= htmlspecialchars($artikel['nama_kategori'] ?? 'Umum') ?>
                    </a>
                </li>
                <li class="sep"><i class="bi bi-chevron-right" style="font-size:10px;"></i></li>
                <li class="current"><?= mb_strimwidth(htmlspecialchars($artikel['judul']), 0, 45, '...') ?></li>
            </ol>

            <!-- Header -->
            <div class="article-header">
                <span class="cat-badge"><?= htmlspecialchars($artikel['nama_kategori'] ?? 'Umum') ?></span>
                <h1 class="article-title"><?= htmlspecialchars($artikel['judul']) ?></h1>
                <div class="article-meta">
                    <span><i class="bi bi-person-fill"></i><?= htmlspecialchars($artikel['nama_penulis'] ?? 'Admin') ?></span>
                    <span><i class="bi bi-calendar3"></i><?= date('d F Y', strtotime($artikel['tanggal'])) ?></span>
                    <span><i class="bi bi-clock"></i><?= $read_time ?> menit baca</span>
                    <span><i class="bi bi-chat-dots"></i><?= $jml_komen ?> komentar</span>
                </div>
            </div>

            <!-- Thumbnail -->
            <?php if ($artikel['thumbnail']): ?>
            <img src="/newsportal/uploads/<?= $artikel['thumbnail'] ?>"
                 alt="<?= htmlspecialchars($artikel['judul']) ?>"
                 class="artikel-thumbnail">
            <?php endif; ?>

            <!-- Isi Artikel -->
            <div class="article-content">
                <?= $artikel['isi_berita'] ?>
            </div>

            <!-- Share Bar -->
            <div class="share-bar">
                <span class="share-label">Bagikan:</span>
                <button class="share-btn" onclick="copyLink()">
                    <i class="bi bi-link-45deg"></i> Salin Link
                </button>
                <a class="share-btn" href="https://wa.me/?text=<?= urlencode($artikel['judul'] . ' - http://localhost/newsportal/detail.php?id=' . $id) ?>" target="_blank">
                    <i class="bi bi-whatsapp" style="color:#25d366;"></i> WhatsApp
                </a>
                <a class="share-btn" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://localhost/newsportal/detail.php?id=' . $id) ?>" target="_blank">
                    <i class="bi bi-facebook" style="color:#1877f2;"></i> Facebook
                </a>
            </div>

            <!-- Artikel Terkait -->
            <?php if (mysqli_num_rows($terkait) > 0): ?>
            <div style="margin-top:32px;">
                <div class="section-header">
                    <div class="section-title">Artikel Terkait</div>
                </div>
                <div class="row g-3">
                    <?php while ($t = mysqli_fetch_assoc($terkait)): ?>
                    <div class="col-md-4">
                        <a href="/newsportal/detail.php?id=<?= $t['id'] ?>" style="display:block; height:100%;">
                            <div class="news-card">
                                <?php if ($t['thumbnail']): ?>
                                    <img class="card-img" src="/newsportal/uploads/<?= $t['thumbnail'] ?>"
                                         alt="<?= htmlspecialchars($t['judul']) ?>"
                                         style="height:130px;">
                                <?php else: ?>
                                    <div class="card-img-placeholder" style="height:130px;"><i class="bi bi-image"></i></div>
                                <?php endif; ?>
                                <div class="card-body" style="padding:12px;">
                                    <div class="card-title" style="font-size:13px;">
                                        <?= htmlspecialchars($t['judul']) ?>
                                    </div>
                                    <div class="card-meta">
                                        <span><i class="bi bi-clock"></i><?= date('d M Y', strtotime($t['tanggal'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- ====== KOMENTAR ====== -->
        <div class="comment-section article-card-pad" style="background:var(--white); border-radius:var(--radius); box-shadow:var(--shadow-sm); margin-top:24px;">

            <?php if (isset($_GET['komentar']) && $_GET['komentar'] == 'sukses'): ?>
            <div style="background:#f0fdf4; border:1.5px solid #86efac; color:#166534; padding:14px 18px; border-radius:var(--radius-sm); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                <i class="bi bi-check-circle-fill"></i>
                Komentar berhasil dikirim! Terima kasih.
            </div>
            <?php endif; ?>

            <!-- Form Komentar -->
            <h4 class="comment-title">
                <i class="bi bi-pencil-square me-2" style="color:var(--red);"></i>Tulis Komentar
            </h4>
            <div class="comment-form-card" style="background:var(--light-gray); padding:24px; border-radius:var(--radius);">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label style="font-size:13px; font-weight:700; margin-bottom:6px; display:block;">Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama kamu" required>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:13px; font-weight:700; margin-bottom:6px; display:block;">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email kamu" required>
                        </div>
                        <div class="col-12">
                            <label style="font-size:13px; font-weight:700; margin-bottom:6px; display:block;">Komentar</label>
                            <textarea name="komentar" class="form-control" rows="4"
                                      placeholder="Tulis pendapatmu..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="kirim" class="btn-primary-red">
                                <i class="bi bi-send"></i> Kirim Komentar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Daftar Komentar -->
            <h5 class="comment-title" style="font-size:16px; margin-top:32px;">
                <i class="bi bi-chat-dots me-2" style="color:var(--red);"></i>
                Komentar Pembaca
                <span style="background:var(--red); color:#fff; font-size:11px; font-weight:700; padding:2px 9px; border-radius:20px; margin-left:8px;">
                    <?= $jml_komen ?>
                </span>
            </h5>

            <?php
            mysqli_data_seek($komentar, 0);
            if ($jml_komen > 0):
                while ($k = mysqli_fetch_assoc($komentar)):
            ?>
            <div class="comment-item">
                <div class="comment-avatar">
                    <?= strtoupper(substr($k['nama'], 0, 1)) ?>
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="comment-name"><?= htmlspecialchars($k['nama']) ?></div>
                    <div class="comment-date">
                        <i class="bi bi-clock me-1"></i>
                        <?= date('d F Y, H:i', strtotime($k['tanggal'])) ?>
                    </div>
                    <div class="comment-text"><?= nl2br(htmlspecialchars($k['komentar'])) ?></div>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div style="text-align:center; padding:40px 0; color:var(--gray);">
                <i class="bi bi-chat-square" style="font-size:2.5rem; opacity:.3; display:block; margin-bottom:12px;"></i>
                Belum ada komentar. Jadilah yang pertama!
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ====== SIDEBAR ====== -->
    <div class="col-lg-4">

        <!-- Tentang Portal -->
        <div class="widget text-center" style="margin-bottom:20px;">
            <div style="width:60px;height:60px;background:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                <i class="bi bi-newspaper" style="color:#fff;font-size:24px;"></i>
            </div>
            <div style="font-size:17px; font-weight:800; color:var(--dark);">NEWS<span style="color:var(--red);">PORTAL</span></div>
            <p style="font-size:13px; color:var(--gray); margin-top:8px; margin-bottom:0;">
                Portal berita terpercaya — akurat, cepat, dan berimbang.
            </p>
        </div>

        <!-- Artikel Terbaru -->
        <div class="widget">
            <div class="widget-title"><i class="bi bi-fire"></i> Artikel Terbaru</div>
            <?php while ($p = mysqli_fetch_assoc($art_populer)): ?>
            <a href="/newsportal/detail.php?id=<?= $p['id'] ?>">
                <div class="list-card">
                    <?php if ($p['thumbnail']): ?>
                        <img src="/newsportal/uploads/<?= $p['thumbnail'] ?>"
                             alt="<?= htmlspecialchars($p['judul']) ?>">
                    <?php else: ?>
                        <div style="width:75px;height:60px;background:var(--light-gray);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-image" style="color:#cbd5e1;"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="list-title"><?= htmlspecialchars($p['judul']) ?></div>
                        <div class="list-meta"><i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($p['tanggal'])) ?></div>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
        </div>

        <!-- Kategori -->
        <div class="widget">
            <div class="widget-title"><i class="bi bi-tags"></i> Kategori</div>
            <ul class="cat-list">
                <?php while ($kat = mysqli_fetch_assoc($semua_kat)):
                    $jml = mysqli_fetch_assoc(mysqli_query($koneksi,
                        "SELECT COUNT(*) AS total FROM artikel WHERE kategori_id='{$kat['id']}'"))['total'];
                ?>
                <li>
                    <a href="/newsportal/kategori.php?id=<?= $kat['id'] ?>">
                        <span><?= htmlspecialchars($kat['nama_kategori']) ?></span>
                        <span class="count"><?= $jml ?></span>
                    </a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

</div>
</div>

<?php include "includes/footer.php"; ?>

<script>
// Reading Progress Bar
window.addEventListener('scroll', function () {
    const doc  = document.documentElement;
    const scrolled = doc.scrollTop;
    const total    = doc.scrollHeight - doc.clientHeight;
    document.getElementById('read-progress').style.width = (scrolled / total * 100) + '%';
});

// Copy link
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function () {
        alert('Link berhasil disalin!');
    });
}
</script>
