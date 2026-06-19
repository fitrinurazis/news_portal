<?php
include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";

$id      = (int) ($_GET['id'] ?? 0);
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, trim($_GET['keyword'])) : '';

$nama_kategori = "Semua Artikel";
if ($id > 0) {
    $kat_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id'"));
    if ($kat_data) $nama_kategori = $kat_data['nama_kategori'];
}

$kondisi = [];
if ($id > 0)        $kondisi[] = "artikel.kategori_id = '$id'";
if ($keyword != '') $kondisi[] = "(artikel.judul LIKE '%$keyword%' OR artikel.isi_berita LIKE '%$keyword%')";
$where = count($kondisi) > 0 ? "WHERE " . implode(" AND ", $kondisi) : "";

$limit         = 8;
$halaman       = isset($_GET['halaman']) ? max(1, (int) $_GET['halaman']) : 1;
$offset        = ($halaman - 1) * $limit;
$total_data    = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS total FROM artikel LEFT JOIN kategori ON artikel.kategori_id = kategori.id $where"))['total'] ?? 0;
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

$semua_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<div class="container" style="padding-top:32px; padding-bottom:60px;">
<div class="row g-4">

    <!-- KONTEN UTAMA -->
    <div class="col-lg-8">

        <!-- Header -->
        <div style="background:var(--white); border-radius:var(--radius); padding:24px 28px; box-shadow:var(--shadow-sm); margin-bottom:20px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="section-title"><?= htmlspecialchars($nama_kategori) ?></div>
                    <div style="font-size:13px; color:var(--gray); margin-top:6px;">
                        <?= $total_data ?> artikel ditemukan
                        <?php if ($keyword): ?>
                            untuk <strong>"<?= htmlspecialchars($keyword) ?>"</strong>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($keyword): ?>
                <a href="/newsportal/kategori.php<?= $id > 0 ? "?id=$id" : "" ?>"
                   class="btn-outline-red">
                    <i class="bi bi-x-lg"></i> Hapus Filter
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-hero">
            <form method="GET" action="/newsportal/kategori.php">
                <?php if ($id > 0): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Cari artikel..." value="<?= htmlspecialchars($keyword) ?>">
                    <button type="submit" class="btn-primary-red" style="border-radius:0 var(--radius-sm) var(--radius-sm) 0; padding:10px 20px;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Artikel -->
        <?php if (mysqli_num_rows($data_artikel) > 0): ?>
        <div class="d-flex flex-column gap-3">
            <?php while ($art = mysqli_fetch_assoc($data_artikel)): ?>
            <a href="/newsportal/detail.php?id=<?= $art['id'] ?>">
                <div class="small-card" style="border-radius:var(--radius);">
                    <?php if ($art['thumbnail']): ?>
                        <img class="small-img" src="/newsportal/uploads/<?= $art['thumbnail'] ?>"
                             alt="<?= htmlspecialchars($art['judul']) ?>"
                             style="width:160px; min-width:160px; height:120px;">
                    <?php else: ?>
                        <div class="small-img-placeholder" style="width:160px; min-width:160px; height:120px;">
                            <i class="bi bi-image" style="color:#cbd5e1; font-size:1.5rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="small-body" style="padding:16px 20px;">
                        <div>
                            <span class="cat-badge" style="font-size:9px; margin-bottom:8px; display:inline-block;">
                                <?= htmlspecialchars($art['nama_kategori'] ?? 'Umum') ?>
                            </span>
                            <div class="small-title" style="font-size:15px; -webkit-line-clamp:2; margin-top:6px;">
                                <?= htmlspecialchars($art['judul']) ?>
                            </div>
                            <div style="font-size:13px; color:var(--gray); margin-top:8px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                <?= mb_strimwidth(strip_tags($art['isi_berita']), 0, 120, '...') ?>
                            </div>
                        </div>
                        <div class="small-meta" style="display:flex; gap:16px; flex-wrap:wrap;">
                            <span><i class="bi bi-person me-1"></i><?= htmlspecialchars($art['nama_penulis'] ?? 'Admin') ?></span>
                            <span><i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($art['tanggal'])) ?></span>
                        </div>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_halaman > 1): ?>
        <div class="pagination-wrap d-flex align-items-center gap-3 flex-wrap">
            <ul class="pagination">
                <?php
                $params_base = array_filter(['id' => $id ?: null, 'keyword' => $keyword ?: null]);
                ?>
                <li>
                    <a class="page-btn <?= $halaman <= 1 ? 'disabled' : '' ?>"
                       href="?<?= http_build_query(array_merge($params_base, ['halaman' => $halaman - 1])) ?>">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                <li>
                    <a class="page-btn <?= $i == $halaman ? 'active' : '' ?>"
                       href="?<?= http_build_query(array_merge($params_base, ['halaman' => $i])) ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
                <li>
                    <a class="page-btn <?= $halaman >= $total_halaman ? 'disabled' : '' ?>"
                       href="?<?= http_build_query(array_merge($params_base, ['halaman' => $halaman + 1])) ?>">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
            <span style="font-size:13px; color:var(--gray);">
                Halaman <?= $halaman ?> / <?= $total_halaman ?>
            </span>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div style="background:var(--white); border-radius:var(--radius); padding:60px 20px; text-align:center; box-shadow:var(--shadow-sm);">
            <i class="bi bi-search" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:16px;"></i>
            <h5 style="color:var(--gray);">
                <?= $keyword ? "Tidak ada artikel untuk \"" . htmlspecialchars($keyword) . "\"" : "Belum ada artikel" ?>
            </h5>
            <a href="/newsportal/kategori.php<?= $id > 0 ? "?id=$id" : "" ?>" class="btn-outline-red mt-3" style="margin-top:16px;">
                Lihat semua artikel
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- SIDEBAR -->
    <div class="col-lg-4">
        <!-- Kategori -->
        <div class="widget">
            <div class="widget-title"><i class="bi bi-tags"></i> Semua Kategori</div>
            <ul class="cat-list">
                <li>
                    <a href="/newsportal/kategori.php" style="<?= $id == 0 && !$keyword ? 'color:var(--red); font-weight:800;' : '' ?>">
                        <span>Semua Artikel</span>
                        <?php
                        $total_all = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM artikel"))['t'];
                        ?>
                        <span class="count"><?= $total_all ?></span>
                    </a>
                </li>
                <?php while ($kat = mysqli_fetch_assoc($semua_kategori)):
                    $jml = mysqli_fetch_assoc(mysqli_query($koneksi,
                        "SELECT COUNT(*) AS total FROM artikel WHERE kategori_id='{$kat['id']}'"))['total'];
                ?>
                <li>
                    <a href="/newsportal/kategori.php?id=<?= $kat['id'] ?>"
                       style="<?= $id == $kat['id'] ? 'color:var(--red); font-weight:800;' : '' ?>">
                        <span><?= htmlspecialchars($kat['nama_kategori']) ?></span>
                        <span class="count"><?= $jml ?></span>
                    </a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Artikel Terbaru -->
        <div class="widget">
            <div class="widget-title"><i class="bi bi-fire"></i> Terbaru</div>
            <?php
            $sidebar_art = mysqli_query($koneksi,
                "SELECT id, judul, thumbnail, tanggal FROM artikel ORDER BY id DESC LIMIT 5");
            while ($p = mysqli_fetch_assoc($sidebar_art)):
            ?>
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
    </div>

</div>
</div>

<?php include "includes/footer.php"; ?>
