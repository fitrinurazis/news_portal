<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ketua') {
    header("Location: /newsportal/auth/login.php");
    exit;
}

$id    = (int) $_POST['id'];
$nama  = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
$email = mysqli_real_escape_string($koneksi, trim($_POST['email']));
$role  = $_POST['role'] == 'ketua' ? 'ketua' : 'admin';

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($koneksi,
        "UPDATE users SET nama='$nama', email='$email', password='$password', role='$role' WHERE id='$id'"
    );
} else {
    mysqli_query($koneksi,
        "UPDATE users SET nama='$nama', email='$email', role='$role' WHERE id='$id'"
    );
}

header("Location: /newsportal/admin/user.php?pesan=update");
exit;
