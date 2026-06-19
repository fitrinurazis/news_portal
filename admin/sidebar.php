<?php
// Deteksi halaman aktif
$current     = basename($_SERVER['PHP_SELF']);           // e.g. index.php
$current_dir = basename(dirname($_SERVER['PHP_SELF']));  // e.g. admin / artikel / kategori

// Tentukan menu mana yang sedang aktif
$active_menu = '';
if ($current_dir === 'artikel') {
    $active_menu = 'artikel';
} elseif ($current_dir === 'kategori') {
    $active_menu = 'kategori';
} elseif ($current === 'user.php') {
    $active_menu = 'user';
} else {
    // index.php atau dashboard.php di folder admin
    $active_menu = 'dashboard';
}
?>

<!-- Sidebar: regular di desktop (lg+), offcanvas di mobile -->
<div class="offcanvas-lg offcanvas-start col-lg-2 admin-sidebar d-flex flex-column"
     id="adminSidebar"
     tabindex="-1"
     style="--bs-offcanvas-width:240px; --bs-offcanvas-bg:#1a1d21; --bs-offcanvas-color:#ced4da;">

    <!-- Header offcanvas (mobile only) -->
    <div class="offcanvas-header d-lg-none" style="background:#1a1d21; border-bottom:1px solid rgba(255,255,255,.08); padding:14px 16px;">
        <div>
            <div style="font-size:15px; font-weight:800; color:#fff; letter-spacing:.5px;">
                NEWS<span style="color:#e53e3e;">PORTAL</span>
            </div>
            <small style="color:#6c757d; font-size:11px;">Admin Panel</small>
        </div>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="offcanvas"
                data-bs-target="#adminSidebar"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column flex-grow-1" style="padding:0; overflow-y:auto; background:#1a1d21;">

        <!-- Brand (desktop only) -->
        <div class="d-none d-lg-block" style="padding:20px 16px 12px; border-bottom:1px solid rgba(255,255,255,.08);">
            <div style="font-size:15px; font-weight:800; color:#fff; letter-spacing:.5px;">
                NEWS<span style="color:#e53e3e;">PORTAL</span>
            </div>
            <small style="color:#6c757d; font-size:11px;">Admin Panel</small>
        </div>

        <!-- User Info -->
        <div style="padding:14px 16px; border-bottom:1px solid rgba(255,255,255,.08);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:50%; background:#e53e3e; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#fff; flex-shrink:0;">
                    <?= strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)) ?>
                </div>
                <div style="min-width:0;">
                    <div style="font-size:13px; font-weight:600; color:#e9ecef; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        <?= htmlspecialchars($_SESSION['nama'] ?? '') ?>
                    </div>
                    <span style="font-size:10px; font-weight:700; background:#e53e3e; color:#fff; padding:1px 7px; border-radius:10px;">
                        <?= strtoupper($_SESSION['role'] ?? '') ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav style="padding:10px 10px; flex:1;">
            <div style="font-size:10px; font-weight:700; color:#495057; letter-spacing:1px; padding:8px 8px 4px; text-transform:uppercase;">Menu</div>

            <a href="/newsportal/admin/index.php"
               class="sidebar-link <?= $active_menu === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <a href="/newsportal/admin/artikel/index.php"
               class="sidebar-link <?= $active_menu === 'artikel' ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i>
                <span>Artikel</span>
            </a>

            <a href="/newsportal/admin/kategori/index.php"
               class="sidebar-link <?= $active_menu === 'kategori' ? 'active' : '' ?>">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>

            <?php if ($_SESSION['role'] == 'ketua'): ?>
            <a href="/newsportal/admin/user.php"
               class="sidebar-link <?= $active_menu === 'user' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                <span>Kelola User</span>
            </a>
            <?php endif; ?>

            <div style="margin-top:12px; border-top:1px solid rgba(255,255,255,.08); padding-top:12px;">
                <a href="/newsportal/index.php" target="_blank" class="sidebar-link">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Lihat Website</span>
                </a>
            </div>
        </nav>

        <!-- Logout -->
        <div style="padding:10px 10px 14px; border-top:1px solid rgba(255,255,255,.08);">
            <a href="/newsportal/admin/logout.php" class="sidebar-link logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>

    </div>
</div>
