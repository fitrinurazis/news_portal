<?php
$ticker_berita = mysqli_query($koneksi, "SELECT id, judul FROM artikel ORDER BY id DESC LIMIT 6");
$ticker_items  = [];
while ($t = mysqli_fetch_assoc($ticker_berita)) $ticker_items[] = $t;
?>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-inner">
            <span class="top-date">
                <i class="bi bi-calendar3 me-1"></i><?= date('l, d F Y') ?>
            </span>
            <div class="top-socials">
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
                    <a href="/newsportal/detail.php?id=<?= $t['id'] ?>"><?= htmlspecialchars($t['judul']) ?></a>
                <?php endforeach; ?>
                <?php foreach ($ticker_items as $t): ?>
                    <span class="sep">&#9679;</span>
                    <a href="/newsportal/detail.php?id=<?= $t['id'] ?>"><?= htmlspecialchars($t['judul']) ?></a>
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
            <a href="/newsportal/index.php" class="nav-brand">NEWS<span>PORTAL</span></a>

            <!-- Nav Links (desktop) -->
            <ul class="nav-links" id="navLinks">
                <li><a href="/newsportal/index.php">Home</a></li>
                <li><a href="/newsportal/kategori.php">Kategori</a></li>
                <li><a href="/newsportal/tentang.php">Tentang</a></li>
                <!-- Search & Login tampil di dalam menu saat mobile -->
                <li class="nav-mobile-search">
                    <form action="/newsportal/kategori.php" method="GET">
                        <div class="nav-search-form" style="border-radius:var(--radius-sm); width:100%;">
                            <button type="submit"><i class="bi bi-search"></i></button>
                            <input type="text" name="keyword" placeholder="Cari berita..." style="width:100%;">
                        </div>
                    </form>
                </li>
                <li class="nav-mobile-login">
                    <a href="/newsportal/auth/login.php" class="nav-login-btn" style="width:100%; justify-content:center;">
                        <i class="bi bi-person-circle me-1"></i>Login
                    </a>
                </li>
            </ul>

            <!-- Kanan: Search + Login (desktop) + Hamburger (mobile) -->
            <div class="nav-right">
                <form class="nav-search-form nav-search-desktop" action="/newsportal/kategori.php" method="GET">
                    <button type="submit"><i class="bi bi-search"></i></button>
                    <input type="text" name="keyword" placeholder="Cari berita...">
                </form>
                <a href="/newsportal/auth/login.php" class="nav-login-btn nav-login-desktop">
                    <i class="bi bi-person-circle me-1"></i>Login
                </a>
                <button class="nav-toggler" id="navToggler" aria-label="Toggle menu">
                    <i class="bi bi-list fs-5" id="navTogglerIcon"></i>
                </button>
            </div>

        </div>
    </div>
</nav>

<script>
const toggler     = document.getElementById('navToggler');
const navLinks    = document.getElementById('navLinks');
const togglerIcon = document.getElementById('navTogglerIcon');

toggler.addEventListener('click', function () {
    const isOpen = navLinks.classList.toggle('open');
    togglerIcon.className = isOpen ? 'bi bi-x fs-5' : 'bi bi-list fs-5';
});

// Tutup menu jika klik di luar
document.addEventListener('click', function (e) {
    if (!navLinks.contains(e.target) && !toggler.contains(e.target)) {
        navLinks.classList.remove('open');
        togglerIcon.className = 'bi bi-list fs-5';
    }
});
</script>
