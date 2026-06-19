<?php
include "../header.php";
include "../sidebar.php";

$data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
$total = mysqli_num_rows($data_kategori);
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold"><i class="bi bi-tags me-2 text-success"></i>Kelola Kategori</h5>
            <small class="text-muted"><?= $total ?> kategori terdaftar</small>
        </div>
        <a href="/newsportal/admin/kategori/tambah.php" class="btn btn-sm btn-success">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </a>
    </div>

    <div class="p-4">

        <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" style="border-radius:10px; border:0; background:#d1e7dd;">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span>
                <?php
                if ($_GET['pesan'] == 'tambah') echo 'Kategori berhasil ditambahkan!';
                if ($_GET['pesan'] == 'edit')   echo 'Kategori berhasil diupdate!';
                if ($_GET['pesan'] == 'hapus')  echo 'Kategori berhasil dihapus!';
                ?>
            </span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row g-4">

            <!-- Tabel Kategori -->
            <div class="col-lg-8">
                <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); overflow:hidden;">
                    <div style="padding:16px 20px; border-bottom:1px solid #dee2e6; display:flex; justify-content:space-between; align-items:center;">
                        <div style="font-weight:700; font-size:14px;">
                            <i class="bi bi-list-ul me-2 text-success"></i>Daftar Kategori
                        </div>
                        <span style="font-size:12px; background:#d1e7dd; color:#198754; font-weight:600; padding:2px 10px; border-radius:20px;">
                            <?= $total ?> kategori
                        </span>
                    </div>
                    <table class="table table-hover mb-0" style="font-size:13.5px;">
                        <thead>
                            <tr style="background:#f8f9fa; border-bottom:1px solid #dee2e6;">
                                <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; width:50px;">#</th>
                                <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Nama Kategori</th>
                                <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; text-align:center;">Jumlah Artikel</th>
                                <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($total > 0):
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($data_kategori)):
                                $jml = mysqli_fetch_assoc(mysqli_query($koneksi,
                                    "SELECT COUNT(*) AS t FROM artikel WHERE kategori_id='{$row['id']}'"))['t'] ?? 0;
                                $colors = ['#0d6efd','#198754','#dc3545','#fd7e14','#6f42c1','#0dcaf0','#e83e8c','#20c997'];
                                $color  = $colors[($row['id'] - 1) % count($colors)];
                        ?>
                        <tr>
                            <td style="padding:13px 20px; vertical-align:middle; color:#adb5bd; font-size:12px;"><?= $no++ ?></td>
                            <td style="padding:13px 20px; vertical-align:middle;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:34px; height:34px; border-radius:8px; background:<?= $color ?>20; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="bi bi-tag" style="color:<?= $color ?>; font-size:14px;"></i>
                                    </div>
                                    <span style="font-weight:600; color:#212529;">
                                        <?= htmlspecialchars($row['nama_kategori']) ?>
                                    </span>
                                </div>
                            </td>
                            <td style="padding:13px 20px; vertical-align:middle; text-align:center;">
                                <span style="background:#f8f9fa; color:#495057; font-size:12px; font-weight:600; padding:3px 10px; border-radius:20px;">
                                    <?= $jml ?> artikel
                                </span>
                            </td>
                            <td style="padding:13px 20px; vertical-align:middle; text-align:right;">
                                <div style="display:flex; gap:6px; justify-content:flex-end;">
                                    <a href="/newsportal/kategori.php?id=<?= $row['id'] ?>" target="_blank"
                                       class="btn btn-sm btn-outline-secondary" title="Lihat"
                                       style="padding:4px 9px; border-radius:6px;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/newsportal/admin/kategori/edit.php?id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-outline-warning" title="Edit"
                                       style="padding:4px 9px; border-radius:6px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/newsportal/admin/kategori/hapus.php?id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-outline-danger" title="Hapus"
                                       style="padding:4px 9px; border-radius:6px;"
                                       onclick="return confirm('Yakin hapus kategori <?= htmlspecialchars($row['nama_kategori']) ?>?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile;
                        else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-tags d-block mb-2" style="font-size:2.5rem; color:#dee2e6;"></i>
                                <div style="color:#6c757d; font-size:14px;">Belum ada kategori.</div>
                                <a href="/newsportal/admin/kategori/tambah.php" class="btn btn-success btn-sm mt-3">
                                    <i class="bi bi-plus-lg me-1"></i>Tambah Kategori Pertama
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Panel Kanan: Form Tambah Cepat -->
            <div class="col-lg-4">
                <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); padding:24px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:18px; padding-bottom:12px; border-bottom:1px solid #dee2e6;">
                        <i class="bi bi-folder-plus me-2 text-success"></i>Tambah Kategori
                    </div>
                    <form method="POST" action="/newsportal/admin/kategori/tambah.php">
                        <div class="mb-3">
                            <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control"
                                   placeholder="Contoh: Teknologi, Olahraga..."
                                   style="border-radius:8px; font-size:13.5px;" required>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-success w-100" style="border-radius:8px;">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "../footer.php"; ?>
