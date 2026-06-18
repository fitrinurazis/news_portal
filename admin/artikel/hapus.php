<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: /newsportal/auth/login.php");
    exit;
}

$id      = (int) $_GET['id'];
$artikel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT thumbnail FROM artikel WHERE id='$id'"));

// Hapus file thumbnail jika ada
if ($artikel && $artikel['thumbnail']) {
    $path_gambar = __DIR__ . '/../../uploads/' . $artikel['thumbnail'];
    if (file_exists($path_gambar)) {
        unlink($path_gambar);
    }
}

mysqli_query($koneksi, "DELETE FROM artikel WHERE id='$id'");

header("Location: /newsportal/admin/artikel/index.php?pesan=hapus");
exit;
