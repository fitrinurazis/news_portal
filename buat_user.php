<?php
include "config/koneksi.php";

// Keamanan: hanya berjalan jika belum ada user
$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users"))['total'] ?? 0;
if ($total > 0) {
    die('<div style="font-family:sans-serif;padding:40px;color:#dc2626;">
        <h3>⚠️ Akses Ditolak</h3>
        <p>User sudah ada di database. File ini tidak bisa dijalankan ulang.</p>
        <p><strong>Hapus file buat_user.php</strong> dari server untuk keamanan.</p>
    </div>');
}

$users = [
    ['Ketua', 'ketua@gmail.com', '12345', 'ketua'],
    ['Admin', 'admin@gmail.com', '12345', 'admin'],
];

echo '<div style="font-family:sans-serif;padding:40px;">';
echo '<h3>Buat User Default</h3>';

foreach ($users as [$nama, $email, $pass, $role]) {
    $nama_esc  = mysqli_real_escape_string($koneksi, $nama);
    $email_esc = mysqli_real_escape_string($koneksi, $email);
    $password  = password_hash($pass, PASSWORD_DEFAULT);
    $q = mysqli_query($koneksi,
        "INSERT INTO users (nama, email, password, role) VALUES ('$nama_esc', '$email_esc', '$password', '$role')"
    );
    echo $q
        ? "<p style='color:green;'>✅ User <strong>$email</strong> ($role) berhasil dibuat.</p>"
        : "<p style='color:red;'>❌ Gagal: " . mysqli_error($koneksi) . "</p>";
}

echo '<hr><p style="color:#dc2626;"><strong>⚠️ Segera hapus file ini setelah selesai!</strong></p>';
echo '</div>';
