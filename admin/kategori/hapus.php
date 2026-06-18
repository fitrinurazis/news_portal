<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: /newsportal/auth/login.php");
    exit;
}

$id = (int) $_GET['id'];
mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id'");

header("Location: /newsportal/admin/kategori/index.php?pesan=hapus");
exit;
