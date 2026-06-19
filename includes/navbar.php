<?php
// Ambil berita terkini untuk ticker
$ticker_berita = mysqli_query($koneksi,
    "SELECT id, judul FROM artikel ORDER BY id DESC LIMIT 6"
);
$ticker_items = [];
while ($t = mysqli_fetch_assoc($ticker_berita)) {
    $ticker_items[] = $t;
}
?>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-calendar3 me-1"></i>
                <?= date('l, d F Y') ?>
            </span>
            <div class="d-flex gap-3">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- BREAKING NEWS TICKER -->
<?php if (count($ticker_items) > 0): ?>
<div class="breaking-bar">
    <div class="container d-flex align-items-center gap-3">
        <span class="breaking-label">TERKINI</span>
        <div class="ticker-wrap">
            <div class="ticker-items">
                <?php foreach ($ticker_items as $i => $t): ?>
                    <?php if ($i > 0): ?><span class="sep">&#9679;</span><?php endif; ?>
                    <a href="/newsportal/detail.php?id=<?= $t['id'] ?>">
                        <?= htmlspecialchars($t['judul']) ?>
                    </a>
                <?php endforeach; ?>
                <?php foreach ($ticker_items as $i => $t): ?>
                    <span class="sep">&#9679;</span>
                    <a href="/newsportal/detail.php?id=<?= $t['id'] ?>">
                        <?= htmlspecialchars($t['judul']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- MAIN NAVBAR -->
<nav class="main-navbar">
    <div class="container">
        <div class="navbar-inner">
            <!-- Brand -->
            <a href="/newsportal/index.php" class="nav-brand">
                NEWS<span>PORTAL</span>
            </a>

            <!-- Nav Links -->
            <ul class="nav-links" id="navLinks">
                <li><a href="/newsportal/index.php">Home</a></li>
                <li><a href="/newsportal/kategori.php">Kategori</a></li>
                <li><a href="/newsportal/tentang.php">Tentang</a></li>
            </ul>

            <!-- Search + Login -->
            <div class="d-flex align-items-center gap-2">
                <form class="nav-search-form" action="/newsportal/kategori.php" method="GET">
                    <button type="submit"><i class="bi bi-search"></i></button>
                    <input type="text" name="keyword" placeholder="Cari berita...">
                </form>
                <a href="/newsportal/auth/login.php" class="nav-links">
                    <a href="/newsportal/auth/login.php" class="nav-login-btn" style="display:inline-block; background:#e03131; color:#fff; font-size:13px; font-weight:700; padding:7px 18px; border-radius:25px; white-space:nowrap;">
                        <i class="bi bi-person-circle me-1"></i>Login
                    </a>
                </a>
                <button class="nav-toggler" id="navToggler">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('navToggler').addEventListener('click', function () {
    document.getElementById('navLinks').classList.toggle('open');
});
</script>
