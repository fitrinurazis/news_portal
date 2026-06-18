<?php
include "config/koneksi.php";

// User 1: Ketua
$nama1 = "Ketua";
$email1 = "ketua@gmail.com";
$password1 = password_hash("12345", PASSWORD_DEFAULT);
$role1 = "ketua";

$query1 = mysqli_query($koneksi, "INSERT INTO users (nama, email, password, role) VALUES ('$nama1', '$email1', '$password1', '$role1')");

if ($query1) {
    echo "User ketua berhasil masuk database<br>";
} else {
    echo "Gagal: " . mysqli_error($koneksi) . "<br>";
}

// User 2: Admin
$nama2 = "Admin";
$email2 = "admin@gmail.com";
$password2 = password_hash("12345", PASSWORD_DEFAULT);
$role2 = "admin";

$query2 = mysqli_query($koneksi, "INSERT INTO users (nama, email, password, role) VALUES ('$nama2', '$email2', '$password2', '$role2')");

if ($query2) {
    echo "User admin berhasil masuk database<br>";
} else {
    echo "Gagal: " . mysqli_error($koneksi) . "<br>";
}
