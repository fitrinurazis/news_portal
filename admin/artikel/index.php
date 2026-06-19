<?php
include "../header.php";
include "../sidebar.php";

// Cek kolom views
$has_views = false;
$qc = mysqli_query($koneksi, "SHOW COLUMNS FROM artikel LIKE 'views'");
if ($qc && mysqli_num_rows($qc) > 0) $has_views = true;

// Search
$keyword = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, trim($_GET['q'])) : '';
$where   = $keyword ? "WHERE artikel.judul LIKE '%$keyword%' OR users.nama LIKE '%$keyword%'" : '';

$views_col = $has_views ? ', artikel.views' : '';
$data_artikel = mysqli_query($koneksi,
    "SELECT artikel.id, artikel.judul, artikel.thumbnail, artikel.tanggal, artikel.kategori_id $views_col,
            kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     $where
     ORDER BY artikel.id DESC"
);

$total = mysqli_num_rows($data_artikel);
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold"><i class="bi bi-newspaper me-2 text-primary"></i>Kelola Artikel</h5>
            <small class="text-muted"><?= $total ?> artikel ditemukan<?= $keyword ? " untuk \"$keyword\"" : '' ?></small>
        </div>
        <a href="/newsportal/admin/artikel/tambah.php" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Artikel
        </a>
    </div>

    <div class="p-4">

        <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" style="border-radius:10px; border:0; background:#d1e7dd;">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span>
                <?php
                if ($_GET['pesan'] == 'tambah') echo 'Artikel berhasil ditambahkan!';
                if ($_GET['pesan'] == 'edit')   echo 'Artikel berhasil diupdate!';
                if ($_GET['pesan'] == 'hapus')  echo 'Artikel berhasil dihapus!';
                ?>
            </span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <form method="GET" class="mb-4">
            <div class="input-group" style="max-width:400px;">
                <span class="input-group-text bg-white border-end-0" style="border-radius:8px 0 0 8px;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="q" class="form-control border-start-0 ps-0"
                       placeholder="Cari judul atau penulis..." value="<?= htmlspecialchars($keyword) ?>"
                       style="border-radius:0 8px 8px 0;">
                <?php if ($keyword): ?>
                <a href="/newsportal/admin/artikel/index.php" class="btn btn-outline-secondary" style="border-radius:0 8px 8px 0;">
                    <i class="bi bi-x-lg"></i>
                </a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Tabel Artikel -->
        <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); overflow:hidden;">
            <div style="overflow-x:auto;">
                <table class="table table-hover mb-0" style="font-size:13.5px;">
                    <thead>
                        <tr style="background:#f8f9fa; border-bottom:2px solid #dee2e6;">
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; width:50px;">#</th>
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Artikel</th>
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Kategori</th>
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Penulis</th>
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Tanggal</th>
                            <?php if ($has_views): ?>
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Views</th>
                            <?php endif; ?>
                            <th style="padding:12px 16px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($total > 0):
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($data_artikel)): ?>
                        <tr>
                            <td style="padding:12px 16px; vertical-align:middle; color:#adb5bd; font-size:12px;"><?= $no++ ?></td>
                            <td style="padding:12px 16px; vertical-align:middle;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <?php if ($row['thumbnail']): ?>
                                        <img src="/newsportal/uploads/<?= $row['thumbnail'] ?>"
                                             style="width:52px;height:40px;object-fit:cover;border-radius:6px;flex-shrink:0;" loading="lazy">
                                    <?php else: ?>
                                        <div style="width:52px;height:40px;background:#f1f3f5;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="bi bi-image" style="color:#ced4da;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div style="max-width:260px;">
                                        <div style="font-weight:600; color:#212529; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?= htmlspecialchars($row['judul']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle;">
                                <span style="background:#e9ecef; color:#495057; font-size:11px; font-weight:600; padding:3px 9px; border-radius:20px;">
                                    <?= htmlspecialchars($row['nama_kategori'] ?? '-') ?>
                                </span>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle; color:#495057;">
                                <?= htmlspecialchars($row['nama_penulis'] ?? '-') ?>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle; color:#6c757d; white-space:nowrap;">
                                <?= date('d M Y', strtotime($row['tanggal'])) ?>
                            </td>
                            <?php if ($has_views): ?>
                            <td style="padding:12px 16px; vertical-align:middle; color:#6c757d;">
                                <i class="bi bi-eye me-1"></i><?= number_format($row['views'] ?? 0) ?>
                            </td>
                            <?php endif; ?>
                            <td style="padding:12px 16px; vertical-align:middle; text-align:right;">
                                <div style="display:flex; gap:6px; justify-content:flex-end;">
                                    <a href="/newsportal/detail.php?id=<?= $row['id'] ?>" target="_blank"
                                       class="btn btn-sm btn-outline-secondary" title="Lihat"
                                       style="padding:4px 9px; border-radius:6px;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/newsportal/admin/artikel/edit.php?id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-outline-warning" title="Edit"
                                       style="padding:4px 9px; border-radius:6px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/newsportal/admin/artikel/hapus.php?id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-outline-danger" title="Hapus"
                                       style="padding:4px 9px; border-radius:6px;"
                                       onclick="return confirm('Yakin hapus artikel ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="<?= $has_views ? 7 : 6 ?>" class="text-center py-5">
                                <i class="bi bi-newspaper d-block mb-2" style="font-size:2.5rem; color:#dee2e6;"></i>
                                <div style="color:#6c757d; font-size:14px;">
                                    <?= $keyword ? "Tidak ada artikel untuk \"<strong>$keyword</strong>\"" : 'Belum ada artikel.' ?>
                                </div>
                                <?php if (!$keyword): ?>
                                <a href="/newsportal/admin/artikel/tambah.php" class="btn btn-primary btn-sm mt-3">
                                    <i class="bi bi-plus-lg me-1"></i>Tambah Artikel Pertama
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include "../footer.php"; ?>
