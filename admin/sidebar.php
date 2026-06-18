<div class="col-md-2 sidebar py-3 d-flex flex-column">
    <!-- Brand -->
    <div class="text-center mb-4 px-3">
        <h5 class="text-white fw-bold mb-0">NEWS PORTAL</h5>
        <small class="text-muted">Admin Panel</small>
    </div>

    <!-- User Info -->
    <div class="px-3 mb-3">
        <div class="bg-secondary bg-opacity-25 rounded p-2 text-center">
            <i class="bi bi-person-circle fs-4 text-light"></i>
            <div class="text-white small mt-1"><?= $_SESSION['nama'] ?></div>
            <span class="badge bg-warning text-dark"><?= strtoupper($_SESSION['role']) ?></span>
        </div>
    </div>

    <!-- Menu -->
    <ul class="nav flex-column px-2 flex-grow-1">
        <li class="nav-item">
            <a class="nav-link" href="/newsportal/admin/index.php">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/newsportal/admin/kategori/index.php">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/newsportal/admin/artikel/index.php">
                <i class="bi bi-newspaper"></i> Artikel
            </a>
        </li>

        <?php if ($_SESSION['role'] == 'ketua'): ?>
        <li class="nav-item">
            <a class="nav-link" href="/newsportal/admin/user.php">
                <i class="bi bi-people"></i> Kelola User
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <!-- Logout -->
    <div class="px-2 pb-3">
        <a class="nav-link text-danger d-flex align-items-center" href="/newsportal/admin/logout.php">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>
