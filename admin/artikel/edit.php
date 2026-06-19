<?php
include "../header.php";
include "../sidebar.php";

$id     = (int) $_GET['id'];
$artikel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM artikel WHERE id='$id'"));

if (!$artikel) {
    header("Location: /newsportal/admin/artikel/index.php");
    exit;
}

$data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

if (isset($_POST['update'])) {
    $judul       = mysqli_real_escape_string($koneksi, trim($_POST['judul']));
    $slug        = mysqli_real_escape_string($koneksi, trim($_POST['slug']));
    $isi_berita  = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
    $kategori_id = (int) $_POST['kategori_id'];
    $thumbnail   = $artikel['thumbnail'];

    // Upload gambar baru jika ada
    if (!empty($_FILES['thumbnail']['name'])) {
        $nama_file = time() . '_' . basename($_FILES['thumbnail']['name']);
        $tujuan    = __DIR__ . '/../../uploads/' . $nama_file;
        $ekstensi  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $izin      = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (in_array($ekstensi, $izin)) {
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $tujuan);
            $thumbnail = $nama_file;
        }
    }

    mysqli_query($koneksi,
        "UPDATE artikel SET
            judul='$judul', slug='$slug', isi_berita='$isi_berita',
            thumbnail='$thumbnail', kategori_id='$kategori_id'
         WHERE id='$id'"
    );

    header("Location: /newsportal/admin/artikel/index.php?pesan=edit");
    exit;
}
?>

<div class="col-lg-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil me-2"></i>Edit Artikel</h5>
        <a href="/newsportal/admin/artikel/index.php" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="p-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">Form Edit Artikel</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Artikel</label>
                                <input type="text" name="judul" id="judul" class="form-control"
                                       value="<?= htmlspecialchars($artikel['judul']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                       value="<?= htmlspecialchars($artikel['slug']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Isi Berita</label>
                                <textarea name="isi_berita" id="isi_berita" class="form-control"
                                          rows="10"><?= $artikel['isi_berita'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    while ($kat = mysqli_fetch_assoc($data_kategori)):
                                    $selected = ($kat['id'] == $artikel['kategori_id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $kat['id'] ?>" <?= $selected ?>>
                                        <?= $kat['nama_kategori'] ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Thumbnail</label>
                                <?php if ($artikel['thumbnail']): ?>
                                    <div class="mb-2">
                                        <img src="/newsportal/uploads/<?= $artikel['thumbnail'] ?>"
                                             class="img-fluid rounded" style="max-height: 150px;">
                                        <small class="text-muted d-block mt-1">Thumbnail saat ini</small>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="thumbnail" class="form-control"
                                       accept="image/*" id="inputGambar">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                <div class="mt-2">
                                    <img id="previewGambar" src="#" alt="Preview"
                                         class="img-fluid rounded d-none" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" name="update" class="btn btn-warning px-4">
                        <i class="bi bi-save me-1"></i>Update Artikel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

<script>
document.getElementById('inputGambar').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('previewGambar');
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
