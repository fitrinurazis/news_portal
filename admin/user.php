<?php
include "header.php";

// Hanya ketua yang boleh akses
if ($_SESSION['role'] != 'ketua') {
    header("Location: /newsportal/admin/dashboard.php");
    exit;
}

include "sidebar.php";

$data_user = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Kelola User</h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-plus-circle me-1"></i>Tambah User
        </button>
    </div>

    <div class="p-4">
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php
                $pesan = $_GET['pesan'];
                if ($pesan == 'tambah') echo 'User berhasil ditambahkan!';
                if ($pesan == 'update') echo 'User berhasil diupdate!';
                if ($pesan == 'hapus')  echo 'User berhasil dihapus!';
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                            <th width="160" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($data_user)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center
                                                justify-content-center fw-bold"
                                         style="width:32px;height:32px;font-size:0.8rem;">
                                        <?= strtoupper(substr($row['nama'], 0, 1)) ?>
                                    </div>
                                    <?= htmlspecialchars($row['nama']) ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <span class="badge <?= $row['role'] == 'ketua' ? 'bg-warning text-dark' : 'bg-secondary' ?>">
                                    <?= strtoupper($row['role']) ?>
                                </span>
                            </td>
                            <td><small><?= date('d/m/Y', strtotime($row['created_at'])) ?></small></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditUser"
                                        data-id="<?= $row['id'] ?>"
                                        data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                        data-email="<?= htmlspecialchars($row['email']) ?>"
                                        data-role="<?= $row['role'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <?php if ($row['id'] != $_SESSION['id']): ?>
                                <a href="/newsportal/admin/hapus.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin hapus user <?= htmlspecialchars($row['nama']) ?>?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-sm btn-danger" disabled title="Tidak bisa hapus akun sendiri">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Tambah User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/newsportal/admin/simpan.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="ketua">Ketua</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/newsportal/admin/update.php">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak diubah">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" id="editRole" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="ketua">Ketua</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
// Isi modal edit dengan data user
document.getElementById('modalEditUser').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('editId').value    = btn.dataset.id;
    document.getElementById('editNama').value  = btn.dataset.nama;
    document.getElementById('editEmail').value = btn.dataset.email;
    document.getElementById('editRole').value  = btn.dataset.role;
});
</script>
