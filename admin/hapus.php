<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ketua') {
    header("Location: /newsportal/auth/login.php");
    exit;
}

$id = (int) $_GET['id'];

// Tidak boleh hapus diri sendiri
if ($id == $_SESSION['id']) {
    header("Location: /newsportal/admin/user.php");
    exit;
}

mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

header("Location: /newsportal/admin/user.php?pesan=hapus");
exit;
