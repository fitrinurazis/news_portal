<?php
include "../header.php";
include "../sidebar.php";

$data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-tags me-2"></i>Kelola Kategori</h5>
        <a href="/newsportal/admin/kategori/tambah.php" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
        </a>
    </div>

    <div class="p-4">
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php
                $pesan = $_GET['pesan'];
                if ($pesan == 'tambah') echo 'Kategori berhasil ditambahkan!';
                if ($pesan == 'edit')   echo 'Kategori berhasil diupdate!';
                if ($pesan == 'hapus')  echo 'Kategori berhasil dihapus!';
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
                            <th>Nama Kategori</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($data_kategori)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_kategori'] ?></td>
                            <td class="text-center">
                                <a href="/newsportal/admin/kategori/edit.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/newsportal/admin/kategori/hapus.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin hapus kategori ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($data_kategori) == 0): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Belum ada kategori. <a href="/newsportal/admin/kategori/tambah.php">Tambah sekarang</a>
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
