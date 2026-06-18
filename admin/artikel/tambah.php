<?php
include "../header.php";
include "../sidebar.php";

$data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

if (isset($_POST['simpan'])) {
    $judul       = mysqli_real_escape_string($koneksi, trim($_POST['judul']));
    $slug        = mysqli_real_escape_string($koneksi, trim($_POST['slug']));
    $isi_berita  = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
    $kategori_id = (int) $_POST['kategori_id'];
    $user_id     = $_SESSION['id'];
    $thumbnail   = '';

    // Upload gambar
    if (!empty($_FILES['thumbnail']['name'])) {
        $nama_file  = time() . '_' . basename($_FILES['thumbnail']['name']);
        $tujuan     = __DIR__ . '/../../uploads/' . $nama_file;
        $ekstensi   = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $izin       = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (in_array($ekstensi, $izin)) {
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $tujuan);
            $thumbnail = $nama_file;
        }
    }

    mysqli_query($koneksi,
        "INSERT INTO artikel (judul, slug, isi_berita, thumbnail, kategori_id, user_id)
         VALUES ('$judul', '$slug', '$isi_berita', '$thumbnail', '$kategori_id', '$user_id')"
    );

    header("Location: /newsportal/admin/artikel/index.php?pesan=tambah");
    exit;
}
?>

<div class="col-md-10 main-content">
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Artikel</h5>
        <a href="/newsportal/admin/artikel/index.php" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="p-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">Form Tambah Artikel</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Artikel</label>
                                <input type="text" name="judul" id="judul" class="form-control"
                                       placeholder="Masukkan judul artikel" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Slug <small class="text-muted">(URL otomatis)</small></label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                       placeholder="url-artikel" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Isi Berita</label>
                                <textarea name="isi_berita" id="isi_berita" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php while ($kat = mysqli_fetch_assoc($data_kategori)): ?>
                                    <option value="<?= $kat['id'] ?>"><?= $kat['nama_kategori'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control"
                                       accept="image/*" id="inputGambar">
                                <div class="mt-2">
                                    <img id="previewGambar" src="#" alt="Preview"
                                         class="img-fluid rounded d-none" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" name="simpan" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i>Simpan Artikel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

<script>
// Auto-generate slug dari judul
document.getElementById('judul').addEventListener('input', function () {
    let slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-');
    document.getElementById('slug').value = slug;
});

// Preview gambar sebelum upload
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
