<?php
include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";

$id      = (int) ($_GET['id'] ?? 0);
$keyword = isset($_GET['keyword'])
    ? mysqli_real_escape_string($koneksi, trim($_GET['keyword']))
    : '';

// Ambil nama kategori jika ada id
$nama_kategori = "Semua Artikel";
if ($id > 0) {
    $kat_data = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id'")
    );
    if ($kat_data) {
        $nama_kategori = $kat_data['nama_kategori'];
    }
}

// Bangun query dengan kondisi
$kondisi = [];
if ($id > 0)        $kondisi[] = "artikel.kategori_id = '$id'";
if ($keyword != '') $kondisi[] = "(artikel.judul LIKE '%$keyword%' OR artikel.isi_berita LIKE '%$keyword%')";
$where = count($kondisi) > 0 ? "WHERE " . implode(" AND ", $kondisi) : "";

// Pagination
$limit    = 5;
$halaman  = isset($_GET['halaman']) ? max(1, (int) $_GET['halaman']) : 1;
$offset   = ($halaman - 1) * $limit;

$total_data    = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS total FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     $where"))['total'] ?? 0;
$total_halaman = $total_data > 0 ? ceil($total_data / $limit) : 1;

$data_artikel = mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     $where
     ORDER BY artikel.id DESC
     LIMIT $offset, $limit"
);

// Semua kategori untuk sidebar
$semua_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<div class="container mt-4 mb-5">
    <div class="row">

        <!-- KONTEN UTAMA -->
        <div class="col-md-8">

            <!-- Header Kategori -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">
                    <i class="bi bi-tags me-2 text-primary"></i><?= htmlspecialchars($nama_kategori) ?>
                </h4>
                <span class="badge bg-primary">
                    <?= mysqli_num_rows($data_artikel) ?> Artikel
                </span>
            </div>

            <!-- Form Pencarian -->
            <form method="GET" action="/newsportal/kategori.php" class="mb-4">
                <?php if ($id > 0): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>
                <div class="input-group shadow-sm">
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Cari artikel di sini..."
                           value="<?= htmlspecialchars($keyword) ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                    <?php if ($keyword): ?>
                    <a href="/newsportal/kategori.php<?= $id > 0 ? "?id=$id" : "" ?>"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php if ($keyword): ?>
                <small class="text-muted mt-1 d-block">
                    Hasil pencarian untuk: <strong>"<?= htmlspecialchars($keyword) ?>"</strong>
                </small>
                <?php endif; ?>
            </form>

            <!-- Daftar Artikel -->
            <?php if (mysqli_num_rows($data_artikel) > 0): ?>
                <?php while ($art = mysqli_fetch_assoc($data_artikel)): ?>
                <div class="card mb-4 shadow-sm border-0">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php if ($art['thumbnail']): ?>
                                <img src="/newsportal/uploads/<?= $art['thumbnail'] ?>"
                                     class="img-fluid rounded-start h-100"
                                     style="object-fit: cover; max-height: 180px; width: 100%;"
                                     alt="<?= htmlspecialchars($art['judul']) ?>">
                            <?php else: ?>
                                <div class="no-image rounded-start h-100" style="min-height:150px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body h-100 d-flex flex-column">
                                <span class="badge bg-primary badge-kategori mb-2" style="width: fit-content;">
                                    <?= htmlspecialchars($art['nama_kategori'] ?? 'Umum') ?>
                                </span>
                                <h5 class="card-title fw-bold">
                                    <a href="/newsportal/detail.php?id=<?= $art['id'] ?>"
                                       class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($art['judul']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= mb_strimwidth(strip_tags($art['isi_berita']), 0, 120, '...') ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-person me-1"></i><?= htmlspecialchars($art['nama_penulis'] ?? 'Admin') ?>
                                        &bull;
                                        <i class="bi bi-calendar3 ms-1 me-1"></i><?= date('d M Y', strtotime($art['tanggal'])) ?>
                                    </small>
                                    <a href="/newsportal/detail.php?id=<?= $art['id'] ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        Baca <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size: 3rem; color: #dee2e6;"></i>
                    <h5 class="mt-3 text-muted">
                        <?= $keyword ? "Artikel tidak ditemukan untuk \"" . htmlspecialchars($keyword) . "\"" : "Belum ada artikel di kategori ini" ?>
                    </h5>
                    <a href="/newsportal/kategori.php<?= $id > 0 ? "?id=$id" : "" ?>"
                       class="btn btn-outline-primary mt-2">
                        Lihat semua artikel
                    </a>
                </div>
            <?php endif; ?>

            <!-- PAGINATION -->
            <?php if ($total_halaman > 1): ?>
            <nav class="mt-4" aria-label="Navigasi halaman">
                <ul class="pagination justify-content-center">
                    <!-- Prev -->
                    <li class="page-item <?= $halaman <= 1 ? 'disabled' : '' ?>">
                        <?php
                        $params_prev = array_filter(['id' => $id ?: null, 'keyword' => $keyword ?: null, 'halaman' => $halaman - 1]);
                        ?>
                        <a class="page-link" href="?<?= http_build_query($params_prev) ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    <!-- Nomor halaman -->
                    <?php for ($i = 1; $i <= $total_halaman; $i++):
                        $params_page = array_filter(['id' => $id ?: null, 'keyword' => $keyword ?: null, 'halaman' => $i]);
                    ?>
                    <li class="page-item <?= $i == $halaman ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($params_page) ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <!-- Next -->
                    <li class="page-item <?= $halaman >= $total_halaman ? 'disabled' : '' ?>">
                        <?php
                        $params_next = array_filter(['id' => $id ?: null, 'keyword' => $keyword ?: null, 'halaman' => $halaman + 1]);
                        ?>
                        <a class="page-link" href="?<?= http_build_query($params_next) ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
                <p class="text-center text-muted small mt-1">
                    Halaman <?= $halaman ?> dari <?= $total_halaman ?>
                    &bull; <?= $total_data ?> artikel ditemukan
                </p>
            </nav>
            <?php endif; ?>
        </div>

        <!-- SIDEBAR -->
        <div class="col-md-4">
            <!-- Semua Kategori -->
            <div class="sidebar-widget">
                <h5><i class="bi bi-tags me-2"></i>Semua Kategori</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="/newsportal/kategori.php"
                           class="text-decoration-none d-flex justify-content-between align-items-center <?= $id == 0 ? 'fw-bold text-primary' : '' ?>">
                            <span><i class="bi bi-grid me-2"></i>Semua Artikel</span>
                        </a>
                    </li>
                    <?php while ($kat = mysqli_fetch_assoc($semua_kategori)): ?>
                    <?php
                    $jml = mysqli_fetch_assoc(mysqli_query($koneksi,
                        "SELECT COUNT(*) AS total FROM artikel WHERE kategori_id='{$kat['id']}'"))['total'];
                    ?>
                    <li class="mb-2">
                        <a href="/newsportal/kategori.php?id=<?= $kat['id'] ?>"
                           class="text-decoration-none d-flex justify-content-between align-items-center <?= $id == $kat['id'] ? 'fw-bold text-primary' : '' ?>">
                            <span><i class="bi bi-chevron-right me-1 text-primary"></i><?= htmlspecialchars($kat['nama_kategori']) ?></span>
                            <span class="badge bg-light text-dark border"><?= $jml ?></span>
                        </a>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Search Global -->
            <div class="sidebar-widget">
                <h5><i class="bi bi-search me-2"></i>Pencarian</h5>
                <form method="GET" action="/newsportal/kategori.php">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control form-control-sm"
                               placeholder="Cari artikel...">
                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>
