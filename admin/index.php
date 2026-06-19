<?php
include "header.php";

if ($_SESSION['role'] == 'ketua') {
    header("Location: /newsportal/admin/dashboard.php");
    exit;
}

include "sidebar.php";

// Statistik
$total_artikel  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM artikel"))['t'] ?? 0;
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM kategori"))['t'] ?? 0;
$total_komentar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM komentar"))['t'] ?? 0;

// Artikel milik user ini
$uid = (int) $_SESSION['id'];
$total_artikel_saya = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS t FROM artikel WHERE user_id='$uid'"))['t'] ?? 0;

// Cek apakah kolom views sudah ada (SHOW COLUMNS tidak throw exception)
$has_views = false;
$qc = mysqli_query($koneksi, "SHOW COLUMNS FROM artikel LIKE 'views'");
if ($qc && mysqli_num_rows($qc) > 0) $has_views = true;

// Total views artikel milik user ini
$total_views = 0;
if ($has_views) {
    $q_views = mysqli_query($koneksi, "SELECT SUM(views) AS t FROM artikel WHERE user_id='$uid'");
    if ($q_views) $total_views = mysqli_fetch_assoc($q_views)['t'] ?? 0;
}

// Artikel terbaru milik user ini
$views_sel = $has_views ? ', artikel.views' : '';
$artikel_terbaru = mysqli_query($koneksi,
    "SELECT artikel.id, artikel.judul, artikel.thumbnail, artikel.tanggal $views_sel,
            kategori.nama_kategori
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     WHERE artikel.user_id = '$uid'
     ORDER BY artikel.id DESC LIMIT 6"
);

// Komentar terbaru pada artikel milik user ini
$komentar_terbaru = mysqli_query($koneksi,
    "SELECT komentar.*, artikel.judul AS judul_artikel
     FROM komentar
     INNER JOIN artikel ON komentar.artikel_id = artikel.id
     WHERE artikel.user_id = '$uid'
     ORDER BY komentar.id DESC LIMIT 5"
);
?>

<div class="col-lg-10 main-content">
    <!-- Top Bar -->
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-person-circle me-2 text-primary"></i>Dashboard <?= ucfirst($_SESSION['role']) ?>
            </h5>
            <small class="text-muted"><?= date('l, d F Y') ?></small>
        </div>
        <div class="d-flex gap-2">
            <a href="/newsportal/admin/artikel/tambah.php" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Artikel Baru
            </a>
            <a href="/newsportal/index.php" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Website
            </a>
        </div>
    </div>

    <div class="p-4">

        <!-- Welcome Banner -->
        <div style="background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:12px; padding:24px 28px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
            <div>
                <div style="font-size:13px; color:rgba(255,255,255,.7); margin-bottom:4px;">Selamat datang kembali,</div>
                <div style="font-size:20px; font-weight:800; color:#fff;">
                    <?= htmlspecialchars($_SESSION['nama']) ?>
                    <span style="background:rgba(255,255,255,.2); color:#fff; font-size:11px; font-weight:700; padding:2px 10px; border-radius:20px; margin-left:8px; vertical-align:middle;">
                        <?= strtoupper($_SESSION['role']) ?>
                    </span>
                </div>
                <div style="font-size:13px; color:rgba(255,255,255,.6); margin-top:6px;">
                    Anda dapat mengelola artikel dan konten portal berita.
                </div>
            </div>
            <div style="font-size:40px; opacity:.15; color:#fff;">
                <i class="bi bi-pencil-square"></i>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <?php
            $stats = [
                ['icon'=>'bi-file-earmark-text', 'color'=>'#0d6efd', 'bg'=>'rgba(13,110,253,.1)',  'value'=>$total_artikel_saya, 'label'=>'Artikel Saya',         'link'=>'/newsportal/admin/artikel/index.php', 'link_text'=>'Lihat semua'],
                ['icon'=>'bi-eye',               'color'=>'#6f42c1', 'bg'=>'rgba(111,66,193,.1)',  'value'=>number_format($total_views), 'label'=>'Views Artikel Saya', 'link'=>'', 'link_text'=>''],
                ['icon'=>'bi-tags',              'color'=>'#198754', 'bg'=>'rgba(25,135,84,.1)',   'value'=>$total_kategori,     'label'=>'Total Kategori',       'link'=>'/newsportal/admin/kategori/index.php', 'link_text'=>'Lihat semua'],
                ['icon'=>'bi-chat-dots',         'color'=>'#dc3545', 'bg'=>'rgba(220,53,69,.1)',   'value'=>$total_komentar,     'label'=>'Total Komentar',       'link'=>'', 'link_text'=>''],
            ];
            foreach ($stats as $s):
            ?>
            <div class="col-md-3 col-6">
                <div style="background:#fff; border-radius:10px; padding:18px; box-shadow:0 1px 6px rgba(0,0,0,.07); border-left:4px solid <?= $s['color'] ?>; height:100%;">
                    <div style="display:flex; align-items:flex-start; gap:12px;">
                        <div style="width:44px; height:44px; border-radius:10px; background:<?= $s['bg'] ?>; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi <?= $s['icon'] ?>" style="font-size:18px; color:<?= $s['color'] ?>;"></i>
                        </div>
                        <div>
                            <div style="font-size:22px; font-weight:800; color:#212529; line-height:1;"><?= $s['value'] ?></div>
                            <div style="font-size:11.5px; color:#6c757d; margin-top:3px;"><?= $s['label'] ?></div>
                            <?php if ($s['link']): ?>
                            <a href="<?= $s['link'] ?>" style="font-size:11px; color:<?= $s['color'] ?>; margin-top:6px; display:block;">
                                <?= $s['link_text'] ?> →
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="row g-4">
            <!-- Artikel Saya Terbaru -->
            <div class="col-lg-8">
                <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); overflow:hidden;">
                    <div style="padding:16px 20px; border-bottom:1px solid #dee2e6; display:flex; justify-content:space-between; align-items:center;">
                        <div style="font-weight:700; font-size:14px;">
                            <i class="bi bi-file-earmark-text me-2 text-primary"></i>Artikel Saya Terbaru
                        </div>
                        <a href="/newsportal/admin/artikel/index.php" style="font-size:12px; color:#0d6efd;">Lihat semua →</a>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="table table-hover mb-0" style="font-size:13px;">
                            <thead style="background:#f8f9fa;">
                                <tr>
                                    <th style="padding:10px 16px; font-size:11.5px; color:#6c757d; font-weight:600; border:0;">ARTIKEL</th>
                                    <th style="padding:10px 16px; font-size:11.5px; color:#6c757d; font-weight:600; border:0;">KATEGORI</th>
                                    <th style="padding:10px 16px; font-size:11.5px; color:#6c757d; font-weight:600; border:0;">TANGGAL</th>
                                    <th style="padding:10px 16px; font-size:11.5px; color:#6c757d; font-weight:600; border:0;">VIEWS</th>
                                    <th style="padding:10px 16px; font-size:11.5px; color:#6c757d; font-weight:600; border:0;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (mysqli_num_rows($artikel_terbaru) > 0):
                                while ($a = mysqli_fetch_assoc($artikel_terbaru)): ?>
                                <tr>
                                    <td style="padding:10px 16px; vertical-align:middle;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <?php if ($a['thumbnail']): ?>
                                                <img src="/newsportal/uploads/<?= $a['thumbnail'] ?>"
                                                     style="width:38px;height:32px;object-fit:cover;border-radius:5px;flex-shrink:0;" loading="lazy">
                                            <?php else: ?>
                                                <div style="width:38px;height:32px;background:#f8f9fa;border-radius:5px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="bi bi-image" style="color:#ced4da;font-size:12px;"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div style="font-weight:600; color:#212529; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                <?= htmlspecialchars($a['judul']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:10px 16px; vertical-align:middle;">
                                        <span style="background:#e9ecef; color:#495057; font-size:11px; font-weight:600; padding:2px 8px; border-radius:4px;">
                                            <?= htmlspecialchars($a['nama_kategori'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td style="padding:10px 16px; vertical-align:middle; color:#6c757d; white-space:nowrap;">
                                        <?= date('d M Y', strtotime($a['tanggal'])) ?>
                                    </td>
                                    <td style="padding:10px 16px; vertical-align:middle; color:#6c757d;">
                                        <i class="bi bi-eye me-1"></i><?= number_format($a['views'] ?? 0) ?>
                                    </td>
                                    <td style="padding:10px 16px; vertical-align:middle;">
                                        <div class="d-flex gap-1">
                                            <a href="/newsportal/detail.php?id=<?= $a['id'] ?>" target="_blank"
                                               class="btn btn-sm btn-outline-secondary" style="padding:2px 7px;" title="Lihat">
                                                <i class="bi bi-eye" style="font-size:11px;"></i>
                                            </a>
                                            <a href="/newsportal/admin/artikel/edit.php?id=<?= $a['id'] ?>"
                                               class="btn btn-sm btn-outline-warning" style="padding:2px 7px;" title="Edit">
                                                <i class="bi bi-pencil" style="font-size:11px;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile;
                            else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-file-earmark-plus d-block mb-2" style="font-size:1.5rem; opacity:.3;"></i>
                                        Belum ada artikel. <a href="/newsportal/admin/artikel/tambah.php">Tambah sekarang →</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Aksi Cepat + Komentar -->
            <div class="col-lg-4">

                <!-- Aksi Cepat -->
                <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); padding:20px; margin-bottom:20px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #dee2e6;">
                        <i class="bi bi-lightning-charge me-2 text-warning"></i>Aksi Cepat
                    </div>
                    <div style="display:grid; gap:8px;">
                        <a href="/newsportal/admin/artikel/tambah.php"
                           style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:8px; background:#e7f1ff; color:#0d6efd; font-size:13px; font-weight:600; text-decoration:none;">
                            <i class="bi bi-plus-circle fs-5"></i> Tulis Artikel Baru
                        </a>
                        <a href="/newsportal/admin/kategori/tambah.php"
                           style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:8px; background:#d1e7dd; color:#198754; font-size:13px; font-weight:600; text-decoration:none;">
                            <i class="bi bi-folder-plus fs-5"></i> Tambah Kategori
                        </a>
                        <a href="/newsportal/admin/artikel/index.php"
                           style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:8px; background:#f8f9fa; color:#495057; font-size:13px; font-weight:600; text-decoration:none;">
                            <i class="bi bi-list-ul fs-5"></i> Semua Artikel Saya
                        </a>
                        <a href="/newsportal/admin/kategori/index.php"
                           style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:8px; background:#f8f9fa; color:#495057; font-size:13px; font-weight:600; text-decoration:none;">
                            <i class="bi bi-tags fs-5"></i> Lihat Kategori
                        </a>
                    </div>
                </div>

                <!-- Komentar Terbaru -->
                <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); padding:20px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #dee2e6;">
                        <i class="bi bi-chat-dots me-2 text-danger"></i>Komentar di Artikel Saya
                    </div>
                    <?php if (mysqli_num_rows($komentar_terbaru) > 0):
                        while ($k = mysqli_fetch_assoc($komentar_terbaru)): ?>
                        <div style="display:flex; gap:10px; padding:10px 0; border-bottom:1px solid #f8f9fa;">
                            <div style="width:34px; height:34px; border-radius:50%; background:#0d6efd; color:#fff; font-size:13px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <?= strtoupper(substr($k['nama'], 0, 1)) ?>
                            </div>
                            <div style="min-width:0; flex:1;">
                                <div style="font-size:13px; font-weight:700; color:#212529;">
                                    <?= htmlspecialchars($k['nama']) ?>
                                </div>
                                <div style="font-size:12px; color:#6c757d; margin-top:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    <?= htmlspecialchars(mb_strimwidth($k['komentar'], 0, 60, '...')) ?>
                                </div>
                                <div style="font-size:11px; color:#adb5bd; margin-top:3px;">
                                    <i class="bi bi-newspaper me-1"></i>
                                    <?= htmlspecialchars(mb_strimwidth($k['judul_artikel'] ?? '-', 0, 30, '...')) ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile;
                    else: ?>
                        <div class="text-center text-muted py-3" style="font-size:13px;">
                            <i class="bi bi-chat-square d-block mb-2" style="font-size:1.5rem; opacity:.3;"></i>
                            Belum ada komentar.
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include "footer.php"; ?>
