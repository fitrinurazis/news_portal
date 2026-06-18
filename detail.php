<?php
include "config/koneksi.php";

$id = (int) ($_GET['id'] ?? 0);

// Simpan komentar SEBELUM output HTML (PRG pattern)
if (isset($_POST['kirim'])) {
    $nama        = htmlspecialchars(trim($_POST['nama']));
    $email       = htmlspecialchars(trim($_POST['email']));
    $isiKomentar = htmlspecialchars(trim($_POST['komentar']));

    if ($nama && $email && $isiKomentar) {
        mysqli_query($koneksi,
            "INSERT INTO komentar (artikel_id, nama, email, komentar)
             VALUES ('$id', '$nama', '$email', '$isiKomentar')"
        );
        // Redirect ke GET agar refresh tidak kirim ulang POST
        header("Location: /newsportal/detail.php?id=$id&komentar=sukses");
        exit;
    }
}

include "includes/header.php";
include "includes/navbar.php";

// Query artikel
$artikel = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     WHERE artikel.id = '$id'
     LIMIT 1"
));

if (!$artikel) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Artikel tidak ditemukan.</div></div>';
    include "includes/footer.php";
    exit;
}

// Query komentar
$komentar = mysqli_query($koneksi,
    "SELECT * FROM komentar WHERE artikel_id='$id' ORDER BY id DESC"
);

// Query artikel terkait (kategori sama)
$artikel_terkait = mysqli_query($koneksi,
    "SELECT * FROM artikel
     WHERE kategori_id = '{$artikel['kategori_id']}' AND id != '$id'
     ORDER BY id DESC
     LIMIT 4"
);

// Query semua kategori untuk sidebar
$semua_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<div class="container mt-4 mb-5">
    <div class="row">

        <!-- KONTEN UTAMA -->
        <div class="col-md-8">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/newsportal/index.php">Home</a></li>
                    <li class="breadcrumb-item">
                        <a href="/newsportal/kategori.php?id=<?= $artikel['kategori_id'] ?>">
                            <?= htmlspecialchars($artikel['nama_kategori'] ?? 'Umum') ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= mb_strimwidth(htmlspecialchars($artikel['judul']), 0, 50, '...') ?>
                    </li>
                </ol>
            </nav>

            <!-- Header Artikel -->
            <span class="badge bg-primary badge-kategori mb-3">
                <?= htmlspecialchars($artikel['nama_kategori'] ?? 'Umum') ?>
            </span>
            <h1 class="fw-bold mb-3" style="line-height: 1.3;">
                <?= htmlspecialchars($artikel['judul']) ?>
            </h1>
            <div class="d-flex align-items-center gap-3 text-muted mb-4">
                <span><i class="bi bi-person-fill me-1"></i><?= htmlspecialchars($artikel['nama_penulis'] ?? 'Admin') ?></span>
                <span><i class="bi bi-calendar3 me-1"></i><?= date('d F Y, H:i', strtotime($artikel['tanggal'])) ?></span>
                <span><i class="bi bi-chat-dots me-1"></i><?= mysqli_num_rows($komentar) ?> Komentar</span>
            </div>

            <!-- Thumbnail -->
            <?php if ($artikel['thumbnail']): ?>
                <img src="/newsportal/uploads/<?= $artikel['thumbnail'] ?>"
                     alt="<?= htmlspecialchars($artikel['judul']) ?>"
                     class="artikel-thumbnail shadow-sm">
            <?php endif; ?>

            <!-- Isi Artikel -->
            <div class="artikel-content">
                <?= $artikel['isi_berita'] ?>
            </div>

            <hr class="mt-5 mb-4">

            <!-- Artikel Terkait -->
            <?php if (mysqli_num_rows($artikel_terkait) > 0): ?>
            <h5 class="fw-bold mb-3"><i class="bi bi-newspaper me-2"></i>Artikel Terkait</h5>
            <div class="row mb-4">
                <?php while ($terkait = mysqli_fetch_assoc($artikel_terkait)): ?>
                <div class="col-md-6 mb-3">
                    <div class="card card-artikel shadow-sm">
                        <?php if ($terkait['thumbnail']): ?>
                            <img src="/newsportal/uploads/<?= $terkait['thumbnail'] ?>"
                                 alt="<?= htmlspecialchars($terkait['judul']) ?>">
                        <?php else: ?>
                            <div class="no-image" style="height:120px;"><i class="bi bi-image"></i></div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="/newsportal/detail.php?id=<?= $terkait['id'] ?>">
                                    <?= htmlspecialchars($terkait['judul']) ?>
                                </a>
                            </h6>
                            <small class="text-muted"><?= date('d M Y', strtotime($terkait['tanggal'])) ?></small>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <hr class="mb-4">
            <?php endif; ?>

            <!-- ===== SISTEM KOMENTAR ===== -->

            <!-- Form Tulis Komentar -->
            <h4 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2"></i>Tulis Komentar</h4>

            <?php if (isset($_GET['komentar']) && $_GET['komentar'] == 'sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>Komentar berhasil dikirim! Terima kasih.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control"
                                       placeholder="Nama kamu" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="Email kamu" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Komentar <span class="text-danger">*</span></label>
                            <textarea name="komentar" class="form-control" rows="4"
                                      placeholder="Tulis komentar kamu di sini..." required></textarea>
                        </div>
                        <button type="submit" name="kirim" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Daftar Komentar -->
            <h5 class="fw-bold mb-3">
                <i class="bi bi-chat-dots me-2"></i>Komentar Pembaca
                <span class="badge bg-secondary ms-1"><?= mysqli_num_rows($komentar) ?></span>
            </h5>

            <?php
            // Reset pointer karena num_rows sudah dipakai
            mysqli_data_seek($komentar, 0);
            if (mysqli_num_rows($komentar) > 0):
                while ($k = mysqli_fetch_assoc($komentar)):
            ?>
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center
                                        justify-content-center fw-bold"
                                 style="width:38px; height:38px; font-size:0.9rem;">
                                <?= strtoupper(substr($k['nama'], 0, 1)) ?>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($k['nama']) ?></h6>
                                <small class="text-muted">
                                    <?= date('d F Y, H:i', strtotime($k['tanggal'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted" style="padding-left: 50px;">
                        <?= nl2br(htmlspecialchars($k['komentar'])) ?>
                    </p>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-chat-square" style="font-size: 2.5rem; opacity: 0.3;"></i>
                <p class="mt-2 mb-0">Belum ada komentar. Jadilah yang pertama!</p>
            </div>
            <?php endif; ?>

        </div>

        <!-- SIDEBAR -->
        <div class="col-md-4">
            <!-- Profil Portal -->
            <div class="sidebar-widget text-center">
                <i class="bi bi-newspaper" style="font-size: 2.5rem; color: #0d6efd;"></i>
                <h5 class="mt-2 mb-1">News Portal</h5>
                <p class="text-muted small">Menyajikan berita terbaru, terpercaya, dan terkini untuk Anda.</p>
            </div>

            <!-- Kategori -->
            <div class="sidebar-widget">
                <h5><i class="bi bi-tags me-2"></i>Kategori</h5>
                <ul class="list-unstyled mb-0">
                    <?php while ($kat = mysqli_fetch_assoc($semua_kategori)): ?>
                    <li class="mb-2">
                        <a href="/newsportal/kategori.php?id=<?= $kat['id'] ?>"
                           class="text-decoration-none d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-chevron-right me-1 text-primary"></i>
                                <?= htmlspecialchars($kat['nama_kategori']) ?>
                            </span>
                            <?php
                            $jml = mysqli_fetch_assoc(mysqli_query($koneksi,
                                "SELECT COUNT(*) AS total FROM artikel WHERE kategori_id='{$kat['id']}'"))['total'];
                            ?>
                            <span class="badge bg-light text-dark border"><?= $jml ?></span>
                        </a>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Artikel Populer (5 terbaru) -->
            <div class="sidebar-widget">
                <h5><i class="bi bi-fire me-2"></i>Artikel Terbaru</h5>
                <?php
                $populer = mysqli_query($koneksi,
                    "SELECT id, judul, tanggal, thumbnail FROM artikel ORDER BY id DESC LIMIT 5");
                while ($p = mysqli_fetch_assoc($populer)):
                ?>
                <div class="d-flex gap-2 mb-3">
                    <?php if ($p['thumbnail']): ?>
                        <img src="/newsportal/uploads/<?= $p['thumbnail'] ?>"
                             width="60" height="50" style="object-fit:cover; border-radius:6px; flex-shrink:0;">
                    <?php else: ?>
                        <div style="width:60px; height:50px; background:#e9ecef; border-radius:6px;
                                    display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <a href="/newsportal/detail.php?id=<?= $p['id'] ?>"
                           class="text-decoration-none text-dark small fw-semibold"
                           style="line-height:1.3; display:block;">
                            <?= mb_strimwidth(htmlspecialchars($p['judul']), 0, 55, '...') ?>
                        </a>
                        <small class="text-muted"><?= date('d M Y', strtotime($p['tanggal'])) ?></small>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>
