<?php
include "header.php";
include "sidebar.php";

// Hapus komentar
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $hapus_id = (int) $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM komentar WHERE id='$hapus_id'");
    header("Location: /newsportal/admin/komentar.php?pesan=hapus");
    exit;
}

// Search
$keyword = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, trim($_GET['q'])) : '';
$where   = $keyword
    ? "WHERE komentar.nama LIKE '%$keyword%' OR komentar.komentar LIKE '%$keyword%' OR artikel.judul LIKE '%$keyword%'"
    : '';

$data_komentar = mysqli_query($koneksi,
    "SELECT komentar.*, artikel.judul AS judul_artikel, artikel.id AS artikel_id
     FROM komentar
     LEFT JOIN artikel ON komentar.artikel_id = artikel.id
     $where
     ORDER BY komentar.id DESC"
);
$total = mysqli_num_rows($data_komentar);
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold"><i class="bi bi-chat-dots me-2 text-danger"></i>Kelola Komentar</h5>
            <small class="text-muted"><?= $total ?> komentar<?= $keyword ? " untuk \"$keyword\"" : '' ?></small>
        </div>
    </div>

    <div class="p-4">

        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus'): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" style="border-radius:10px; border:0; background:#d1e7dd;">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span>Komentar berhasil dihapus.</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Search -->
        <form method="GET" class="mb-4">
            <div class="input-group" style="max-width:420px;">
                <span class="input-group-text bg-white border-end-0" style="border-radius:8px 0 0 8px;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="q" class="form-control border-start-0 ps-0"
                       placeholder="Cari nama, isi komentar, atau judul artikel..."
                       value="<?= htmlspecialchars($keyword) ?>"
                       style="border-radius:0 8px 8px 0;">
                <?php if ($keyword): ?>
                <a href="/newsportal/admin/komentar.php" class="btn btn-outline-secondary" style="border-radius:0 8px 8px 0;">
                    <i class="bi bi-x-lg"></i>
                </a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Daftar Komentar -->
        <?php if ($total > 0): ?>
        <div class="d-flex flex-column gap-3">
        <?php while ($row = mysqli_fetch_assoc($data_komentar)): ?>
            <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); padding:18px 20px;">
                <div style="display:flex; gap:14px; align-items:flex-start;">

                    <!-- Avatar -->
                    <div style="width:40px; height:40px; border-radius:50%; background:#dc3545; display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:700; color:#fff; flex-shrink:0;">
                        <?= strtoupper(substr($row['nama'], 0, 1)) ?>
                    </div>

                    <!-- Konten -->
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px;">
                            <span style="font-weight:700; color:#212529; font-size:14px;">
                                <?= htmlspecialchars($row['nama']) ?>
                            </span>
                            <span style="font-size:12px; color:#6c757d;">
                                <?= htmlspecialchars($row['email']) ?>
                            </span>
                            <span style="font-size:11px; color:#adb5bd; margin-left:auto; white-space:nowrap;">
                                <i class="bi bi-clock me-1"></i>
                                <?= date('d M Y, H:i', strtotime($row['created_at'] ?? 'now')) ?>
                            </span>
                        </div>

                        <!-- Isi komentar -->
                        <div style="font-size:13.5px; color:#495057; line-height:1.6; margin-bottom:10px;">
                            <?= nl2br(htmlspecialchars($row['komentar'])) ?>
                        </div>

                        <!-- Footer: link artikel + tombol hapus -->
                        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                            <a href="/newsportal/detail.php?id=<?= $row['artikel_id'] ?>" target="_blank"
                               style="font-size:12px; color:#0d6efd; text-decoration:none; display:flex; align-items:center; gap:5px; max-width:70%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                <i class="bi bi-newspaper" style="flex-shrink:0;"></i>
                                <?= htmlspecialchars($row['judul_artikel'] ?? 'Artikel dihapus') ?>
                            </a>
                            <a href="/newsportal/admin/komentar.php?hapus=<?= $row['id'] ?>&<?= $keyword ? 'q='.urlencode($keyword) : '' ?>"
                               class="btn btn-sm btn-outline-danger"
                               style="padding:3px 10px; border-radius:6px; font-size:12px; flex-shrink:0;"
                               onclick="return confirm('Yakin hapus komentar ini?')">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>

        <?php else: ?>
        <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); padding:60px 20px; text-align:center;">
            <i class="bi bi-chat-square" style="font-size:3rem; color:#dee2e6; display:block; margin-bottom:12px;"></i>
            <div style="color:#6c757d; font-size:14px;">
                <?= $keyword ? "Tidak ada komentar untuk \"<strong>$keyword</strong>\"" : 'Belum ada komentar masuk.' ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include "footer.php"; ?>
