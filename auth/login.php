<?php
session_start();
include "../config/koneksi.php";

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['role'])) {
    $redirect = $_SESSION['role'] == 'ketua' ? '/newsportal/admin/dashboard.php' : '/newsportal/admin/index.php';
    header("Location: $redirect");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id']   = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        $redirect = $user['role'] == 'ketua' ? '/newsportal/admin/dashboard.php' : '/newsportal/admin/index.php';
        header("Location: $redirect");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - News Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center py-4">
                        <h4 class="mb-0 fw-bold">NEWS PORTAL</h4>
                        <small class="text-muted">Admin Panel</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-dark w-100 py-2">
                                Login
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted small py-3">
                        <a href="../index.php" class="text-decoration-none">← Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
