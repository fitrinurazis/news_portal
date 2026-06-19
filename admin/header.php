<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: /newsportal/auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - News Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f1f3f5; }

        /* ── Sidebar ── */
        /* Bootstrap offcanvas-lg sets background-color: transparent !important on desktop,
           so we need !important here to override it */
        .admin-sidebar {
            background: #1a1d21 !important;
            min-height: 100vh;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 7px;
            margin-bottom: 2px;
            color: #ced4da !important;
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none !important;
            transition: background .15s, color .15s;
        }
        .sidebar-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            color: #6c757d !important;
            transition: color .15s;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff !important;
        }
        .sidebar-link:hover i { color: #e2e8f0 !important; }
        .sidebar-link.active {
            background: rgba(229,62,62,.15);
            color: #fc8181 !important;
            font-weight: 600;
        }
        .sidebar-link.active i { color: #e53e3e !important; }
        .sidebar-link.logout { color: #fc8181 !important; }
        .sidebar-link.logout i { color: #fc8181 !important; }
        .sidebar-link.logout:hover { color: #fff !important; background: rgba(229,62,62,.2); }

        /* ── Main content ── */
        .main-content { background: #f1f3f5; min-height: 100vh; }
        .top-bar {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* ── Mobile topbar ── */
        .admin-mobile-bar {
            background: #1a1d21;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 1050;
        }
        .admin-mobile-bar .brand {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            letter-spacing: .5px;
            flex: 1;
        }
        .admin-mobile-bar .brand span { color: #e53e3e; }
    </style>
</head>
<body>

<!-- Mobile topbar: hanya muncul di layar kecil (< lg) -->
<div class="admin-mobile-bar d-lg-none">
    <button class="btn btn-sm btn-outline-light"
            data-bs-toggle="offcanvas"
            data-bs-target="#adminSidebar"
            aria-controls="adminSidebar">
        <i class="bi bi-list fs-5"></i>
    </button>
    <div class="brand">NEWS<span>PORTAL</span></div>
    <span style="background:#e53e3e; color:#fff; font-size:10px; font-weight:700; padding:2px 8px; border-radius:10px;"><?= strtoupper($_SESSION['role'] ?? '') ?></span>
</div>

<div class="container-fluid p-0">
<div class="row g-0">
