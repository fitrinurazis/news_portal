<footer class="main-footer">
    <div class="container">
        <div class="row g-4">

            <!-- Brand -->
            <div class="col-12 col-md-4">
                <div class="footer-brand">NEWS<span>PORTAL</span></div>
                <p class="footer-desc">
                    Portal berita digital terpercaya yang menyajikan informasi terkini,
                    akurat, dan berimbang untuk masyarakat Indonesia.
                </p>
                <div class="footer-socials">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Navigasi -->
            <div class="col-6 col-sm-3 col-md-2">
                <div class="footer-heading">Navigasi</div>
                <ul class="footer-links">
                    <li><a href="/newsportal/index.php">Home</a></li>
                    <li><a href="/newsportal/kategori.php">Kategori</a></li>
                    <li><a href="/newsportal/tentang.php">Tentang Kami</a></li>
                    <li><a href="/newsportal/auth/login.php">Login Admin</a></li>
                </ul>
            </div>

            <!-- Kategori -->
            <div class="col-6 col-sm-3 col-md-3">
                <div class="footer-heading">Kategori</div>
                <ul class="footer-links">
                    <?php
                    $kat_footer = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC LIMIT 6");
                    while ($kf = mysqli_fetch_assoc($kat_footer)):
                    ?>
                    <li>
                        <a href="/newsportal/kategori.php?id=<?= $kf['id'] ?>">
                            <?= htmlspecialchars($kf['nama_kategori']) ?>
                        </a>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="footer-heading">Kontak</div>
                <ul class="footer-links">
                    <li><a href="#"><i class="bi bi-envelope me-2"></i>redaksi@newsportal.com</a></li>
                    <li><a href="#"><i class="bi bi-telephone me-2"></i>(021) 1234-5678</a></li>
                    <li><a href="#"><i class="bi bi-geo-alt me-2"></i>Jakarta, Indonesia</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            &copy; <?= date('Y') ?> NewsPortal. Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
