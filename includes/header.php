<?php
$page_title     = $page_title     ?? 'NewsPortal — Berita Terbaru & Terpercaya';
$og_title       = $og_title       ?? 'NewsPortal — Berita Terbaru & Terpercaya';
$og_description = $og_description ?? 'Portal berita digital terpercaya yang menyajikan informasi terkini, akurat, dan berimbang untuk masyarakat Indonesia.';
$og_image       = $og_image       ?? '';
$og_url         = $og_url         ?? 'http://localhost/newsportal/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $og_description ?>">

    <!-- Open Graph (WhatsApp, Facebook, Telegram) -->
    <meta property="og:type"        content="article">
    <meta property="og:title"       content="<?= $og_title ?>">
    <meta property="og:description" content="<?= $og_description ?>">
    <meta property="og:url"         content="<?= $og_url ?>">
    <?php if ($og_image): ?>
    <meta property="og:image"       content="<?= $og_image ?>">
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?= $og_title ?>">
    <meta name="twitter:description" content="<?= $og_description ?>">
    <?php if ($og_image): ?>
    <meta name="twitter:image"       content="<?= $og_image ?>">
    <?php endif; ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/newsportal/assets/css/style.css">
</head>
<body>
