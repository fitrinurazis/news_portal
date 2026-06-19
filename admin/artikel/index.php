<?php
include "../header.php";
include "../sidebar.php";

$data_artikel = mysqli_query($koneksi,
    "SELECT artikel.*, kategori.nama_kategori, users.nama AS nama_penulis
     FROM artikel
     LEFT JOIN kategori ON artikel.kategori_id = kategori.id
     LEFT JOIN users ON artikel.user_id = users.id
     ORDER BY artikel.id DESC"
);
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-newspaper me-2"></i>Kelola Artikel</h5>
        <a href="/newsportal/admin/artikel/tambah.php" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Tambah Artikel
        </a>
    </div>

    <div class="p-4">
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php
                $pesan = $_GET['pesan'];
                if ($pesan == 'tambah') echo 'Artikel berhasil ditambahkan!';
                if ($pesan == 'edit')   echo 'Artikel berhasil diupdate!';
                if ($pesan == 'hapus')  echo 'Artikel berhasil dihapus!';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th width="80">Thumbnail</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th width="160" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($data_artikel)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if ($row['thumbnail']): ?>
                                    <img src="/newsportal/uploads/<?= $row['thumbnail'] ?>"
                                         width="60" height="45" style="object-fit:cover; border-radius:4px;">
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['judul']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= $row['nama_kategori'] ?? '-' ?></span>
                            </td>
                            <td><?= $row['nama_penulis'] ?? '-' ?></td>
                            <td><small><?= date('d/m/Y', strtotime($row['tanggal'])) ?></small></td>
                            <td class="text-center">
                                <a href="/newsportal/admin/artikel/edit.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/newsportal/admin/artikel/hapus.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin hapus artikel ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($data_artikel) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada artikel. <a href="/newsportal/admin/artikel/tambah.php">Tambah sekarang</a>
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
