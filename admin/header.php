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
    <title>Admin - News Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #212529;
            padding-top: 10px;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 4px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 8px;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .top-bar {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid p-0">
<div class="row g-0">
