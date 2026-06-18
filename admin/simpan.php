<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ketua') {
    header("Location: /newsportal/auth/login.php");
    exit;
}

$nama     = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
$email    = mysqli_real_escape_string($koneksi, trim($_POST['email']));
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role     = $_POST['role'] == 'ketua' ? 'ketua' : 'admin';

$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id FROM users WHERE email='$email'"));
if ($cek) {
    header("Location: /newsportal/admin/user.php?pesan=email_duplikat");
    exit;
}

mysqli_query($koneksi,
    "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')"
);

header("Location: /newsportal/admin/user.php?pesan=tambah");
exit;
