<?php
include "../header.php";
include "../sidebar.php";

if (isset($_POST['simpan'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, trim($_POST['nama_kategori']));

    if ($nama_kategori != '') {
        mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
        header("Location: /newsportal/admin/kategori/index.php?pesan=tambah");
        exit;
    }
}
?>

<div class="col-md-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori</h5>
        <a href="/newsportal/admin/kategori/index.php" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="p-4">
        <div class="card shadow-sm" style="max-width: 500px;">
            <div class="card-header bg-dark text-white fw-bold">Form Tambah Kategori</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control"
                               placeholder="Contoh: Teknologi" required>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>
