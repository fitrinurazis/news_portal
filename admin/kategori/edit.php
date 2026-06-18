<?php
include "../header.php";
include "../sidebar.php";

$id = (int) $_GET['id'];
$kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id'"));

if (!$kategori) {
    header("Location: /newsportal/admin/kategori/index.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, trim($_POST['nama_kategori']));

    if ($nama_kategori != '') {
        mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id='$id'");
        header("Location: /newsportal/admin/kategori/index.php?pesan=edit");
        exit;
    }
}
?>

<div class="col-md-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil me-2"></i>Edit Kategori</h5>
        <a href="/newsportal/admin/kategori/index.php" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="p-4">
        <div class="card shadow-sm" style="max-width: 500px;">
            <div class="card-header bg-dark text-white fw-bold">Form Edit Kategori</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control"
                               value="<?= $kategori['nama_kategori'] ?>" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-warning w-100">
                        <i class="bi bi-save me-1"></i>Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>
