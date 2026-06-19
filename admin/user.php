<?php
include "header.php";

if ($_SESSION['role'] != 'ketua') {
    header("Location: /newsportal/admin/index.php");
    exit;
}

include "sidebar.php";

$data_user  = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
$total_user = mysqli_num_rows($data_user);
$total_ketua = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM users WHERE role='ketua'"))['t'] ?? 0;
$total_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM users WHERE role='admin'"))['t'] ?? 0;
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2 text-warning"></i>Kelola User</h5>
            <small class="text-muted"><?= $total_user ?> user terdaftar</small>
        </div>
        <button class="btn btn-sm btn-warning text-dark fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-person-plus me-1"></i>Tambah User
        </button>
    </div>

    <div class="p-4">

        <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" style="border-radius:10px; border:0; background:#d1e7dd;">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span>
                <?php
                if ($_GET['pesan'] == 'tambah') echo 'User berhasil ditambahkan!';
                if ($_GET['pesan'] == 'update') echo 'User berhasil diupdate!';
                if ($_GET['pesan'] == 'hapus')  echo 'User berhasil dihapus!';
                ?>
            </span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div style="background:#fff; border-radius:10px; padding:18px 20px; box-shadow:0 1px 6px rgba(0,0,0,.07); border-left:4px solid #ffc107; display:flex; align-items:center; gap:14px;">
                    <div style="width:44px; height:44px; border-radius:10px; background:rgba(255,193,7,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-people" style="font-size:18px; color:#ffc107;"></i>
                    </div>
                    <div>
                        <div style="font-size:24px; font-weight:800; color:#212529; line-height:1;"><?= $total_user ?></div>
                        <div style="font-size:12px; color:#6c757d; margin-top:2px;">Total User</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#fff; border-radius:10px; padding:18px 20px; box-shadow:0 1px 6px rgba(0,0,0,.07); border-left:4px solid #e53e3e; display:flex; align-items:center; gap:14px;">
                    <div style="width:44px; height:44px; border-radius:10px; background:rgba(229,62,62,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-shield-check" style="font-size:18px; color:#e53e3e;"></i>
                    </div>
                    <div>
                        <div style="font-size:24px; font-weight:800; color:#212529; line-height:1;"><?= $total_ketua ?></div>
                        <div style="font-size:12px; color:#6c757d; margin-top:2px;">Ketua</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#fff; border-radius:10px; padding:18px 20px; box-shadow:0 1px 6px rgba(0,0,0,.07); border-left:4px solid #0d6efd; display:flex; align-items:center; gap:14px;">
                    <div style="width:44px; height:44px; border-radius:10px; background:rgba(13,110,253,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-person-badge" style="font-size:18px; color:#0d6efd;"></i>
                    </div>
                    <div>
                        <div style="font-size:24px; font-weight:800; color:#212529; line-height:1;"><?= $total_admin ?></div>
                        <div style="font-size:12px; color:#6c757d; margin-top:2px;">Admin</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel User -->
        <div style="background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.07); overflow:hidden;">
            <div style="padding:16px 20px; border-bottom:1px solid #dee2e6; font-weight:700; font-size:14px;">
                <i class="bi bi-list-ul me-2 text-warning"></i>Daftar User
            </div>
            <div style="overflow-x:auto;">
                <table class="table table-hover mb-0" style="font-size:13.5px;">
                    <thead>
                        <tr style="background:#f8f9fa; border-bottom:1px solid #dee2e6;">
                            <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; width:50px;">#</th>
                            <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Nama</th>
                            <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Email</th>
                            <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; text-align:center;">Role</th>
                            <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0;">Terdaftar</th>
                            <th style="padding:11px 20px; font-size:11px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.5px; border:0; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data_user)):
                        $is_me = ($row['id'] == $_SESSION['id']);
                        $avatar_bg = $row['role'] == 'ketua' ? '#e53e3e' : '#0d6efd';
                    ?>
                    <tr>
                        <td style="padding:13px 20px; vertical-align:middle; color:#adb5bd; font-size:12px;"><?= $no++ ?></td>
                        <td style="padding:13px 20px; vertical-align:middle;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:<?= $avatar_bg ?>; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#fff; flex-shrink:0;">
                                    <?= strtoupper(substr($row['nama'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight:600; color:#212529;">
                                        <?= htmlspecialchars($row['nama']) ?>
                                        <?php if ($is_me): ?>
                                        <span style="font-size:10px; background:#e7f1ff; color:#0d6efd; padding:1px 7px; border-radius:10px; font-weight:600; margin-left:4px;">Anda</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:13px 20px; vertical-align:middle; color:#6c757d;">
                            <?= htmlspecialchars($row['email']) ?>
                        </td>
                        <td style="padding:13px 20px; vertical-align:middle; text-align:center;">
                            <?php if ($row['role'] == 'ketua'): ?>
                            <span style="background:rgba(229,62,62,.1); color:#e53e3e; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px;">
                                <i class="bi bi-shield-check me-1"></i>KETUA
                            </span>
                            <?php else: ?>
                            <span style="background:#e7f1ff; color:#0d6efd; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px;">
                                <i class="bi bi-person-badge me-1"></i>ADMIN
                            </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding:13px 20px; vertical-align:middle; color:#6c757d; white-space:nowrap;">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td style="padding:13px 20px; vertical-align:middle; text-align:right;">
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <button class="btn btn-sm btn-outline-warning" title="Edit"
                                        style="padding:4px 9px; border-radius:6px;"
                                        data-bs-toggle="modal" data-bs-target="#modalEditUser"
                                        data-id="<?= $row['id'] ?>"
                                        data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                        data-email="<?= htmlspecialchars($row['email']) ?>"
                                        data-role="<?= $row['role'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <?php if (!$is_me): ?>
                                <a href="/newsportal/admin/hapus.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-outline-danger" title="Hapus"
                                   style="padding:4px 9px; border-radius:6px;"
                                   onclick="return confirm('Yakin hapus user <?= htmlspecialchars($row['nama']) ?>?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-sm btn-outline-danger" disabled title="Tidak bisa hapus akun sendiri"
                                        style="padding:4px 9px; border-radius:6px; opacity:.4;">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:0; border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#1a1d21; border:0; padding:18px 24px;">
                <h5 class="modal-title fw-bold text-white" style="font-size:15px;">
                    <i class="bi bi-person-plus me-2"></i>Tambah User Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/newsportal/admin/simpan.php">
                <div class="modal-body" style="padding:24px;">
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required style="border-radius:8px;">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required style="border-radius:8px;">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required style="border-radius:8px;">
                    </div>
                    <div class="mb-1">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Role</label>
                        <select name="role" class="form-select" required style="border-radius:8px;">
                            <option value="admin">Admin</option>
                            <option value="ketua">Ketua</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border:0; padding:16px 24px; background:#f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold" style="border-radius:8px;">
                        <i class="bi bi-save me-1"></i>Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:0; border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#1a1d21; border:0; padding:18px 24px;">
                <h5 class="modal-title fw-bold text-white" style="font-size:15px;">
                    <i class="bi bi-pencil-square me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/newsportal/admin/update.php">
                <div class="modal-body" style="padding:24px;">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Nama Lengkap</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required style="border-radius:8px;">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required style="border-radius:8px;">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Password Baru</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak diubah" style="border-radius:8px;">
                        <small style="color:#6c757d; font-size:11.5px; margin-top:4px; display:block;">Biarkan kosong jika tidak ingin mengubah password</small>
                    </div>
                    <div class="mb-1">
                        <label style="font-size:13px; font-weight:600; color:#495057; margin-bottom:6px; display:block;">Role</label>
                        <select name="role" id="editRole" class="form-select" required style="border-radius:8px;">
                            <option value="admin">Admin</option>
                            <option value="ketua">Ketua</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border:0; padding:16px 24px; background:#f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold" style="border-radius:8px;">
                        <i class="bi bi-save me-1"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
document.getElementById('modalEditUser').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('editId').value    = btn.dataset.id;
    document.getElementById('editNama').value  = btn.dataset.nama;
    document.getElementById('editEmail').value = btn.dataset.email;
    document.getElementById('editRole').value  = btn.dataset.role;
});
</script>
