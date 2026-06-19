<?php
include "config/koneksi.php";

$page_title     = 'Tentang Kami — NewsPortal';
$og_title       = 'Tentang NewsPortal';
$og_description = 'Portal berita digital terpercaya yang menyajikan informasi terkini, akurat, dan berimbang untuk masyarakat Indonesia.';

include "includes/header.php";
include "includes/navbar.php";

$total_artikel  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM artikel"))['t'] ?? 0;
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM kategori"))['t'] ?? 0;
$total_komentar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM komentar"))['t'] ?? 0;
?>

<!-- Hero Banner -->
<div style="background:linear-gradient(135deg, var(--dark) 0%, #1e293b 100%); padding:70px 0 60px; margin-bottom:0;">
    <div class="container text-center">
        <div style="width:72px;height:72px;background:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="bi bi-newspaper" style="color:#fff;font-size:30px;"></i>
        </div>
        <h1 style="font-size:clamp(24px,5vw,40px); font-weight:800; color:#fff; margin-bottom:14px;">
            NEWS<span style="color:var(--red);">PORTAL</span>
        </h1>
        <p style="font-size:16px; color:#94a3b8; max-width:560px; margin:0 auto; line-height:1.8;">
            Portal berita digital terpercaya yang menyajikan informasi terkini,
            akurat, dan berimbang untuk masyarakat Indonesia.
        </p>
    </div>
</div>

<!-- Stats Bar -->
<div style="background:var(--red); padding:20px 0; margin-bottom:48px;">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-4">
                <div style="color:#fff;">
                    <div style="font-size:clamp(24px,5vw,36px); font-weight:800; line-height:1;"><?= $total_artikel ?></div>
                    <div style="font-size:12px; opacity:.85; margin-top:4px; text-transform:uppercase; letter-spacing:1px;">Artikel</div>
                </div>
            </div>
            <div class="col-4" style="border-left:1px solid rgba(255,255,255,.25); border-right:1px solid rgba(255,255,255,.25);">
                <div style="color:#fff;">
                    <div style="font-size:clamp(24px,5vw,36px); font-weight:800; line-height:1;"><?= $total_kategori ?></div>
                    <div style="font-size:12px; opacity:.85; margin-top:4px; text-transform:uppercase; letter-spacing:1px;">Kategori</div>
                </div>
            </div>
            <div class="col-4">
                <div style="color:#fff;">
                    <div style="font-size:clamp(24px,5vw,36px); font-weight:800; line-height:1;"><?= $total_komentar ?></div>
                    <div style="font-size:12px; opacity:.85; margin-top:4px; text-transform:uppercase; letter-spacing:1px;">Komentar</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding-bottom:60px;">

    <!-- Visi & Misi -->
    <div class="section-header" style="margin-bottom:28px;">
        <div class="section-title">Visi &amp; Misi</div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div style="background:var(--white); border-radius:var(--radius); padding:28px; box-shadow:var(--shadow-sm); height:100%; border-top:4px solid var(--red);">
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                    <div style="width:44px;height:44px;background:rgba(224,49,49,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-eye" style="color:var(--red); font-size:18px;"></i>
                    </div>
                    <h4 style="font-weight:800; color:var(--dark); margin:0;">Visi</h4>
                </div>
                <p style="color:var(--gray); font-size:14.5px; line-height:1.8; margin:0;">
                    Menjadi portal berita digital terpercaya yang mengedepankan
                    akurasi, objektivitas, dan kecepatan dalam penyampaian informasi
                    kepada masyarakat luas.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background:var(--white); border-radius:var(--radius); padding:28px; box-shadow:var(--shadow-sm); height:100%; border-top:4px solid var(--dark);">
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                    <div style="width:44px;height:44px;background:var(--light-gray);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-bullseye" style="color:var(--dark); font-size:18px;"></i>
                    </div>
                    <h4 style="font-weight:800; color:var(--dark); margin:0;">Misi</h4>
                </div>
                <ul style="color:var(--gray); font-size:14.5px; line-height:2; margin:0; padding-left:18px;">
                    <li>Menyajikan berita yang akurat dan terverifikasi</li>
                    <li>Memberikan informasi yang bermanfaat bagi masyarakat</li>
                    <li>Menjaga independensi dan objektivitas jurnalistik</li>
                    <li>Menghadirkan konten edukatif dan informatif</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Keunggulan -->
    <div class="section-header" style="margin-bottom:28px;">
        <div class="section-title">Mengapa NewsPortal?</div>
    </div>
    <div class="row g-3 mb-5">
        <?php
        $features = [
            ['bi-lightning-charge', '#fbbf24', 'Cepat & Terkini',  'Berita terbaru selalu tersedia. Kami berkomitmen menyajikan informasi secepat mungkin.'],
            ['bi-shield-check',    '#22c55e', 'Terpercaya',        'Setiap berita diverifikasi oleh tim redaksi sebelum dipublikasikan.'],
            ['bi-phone',           '#3b82f6', 'Responsif',         'Tampilan optimal di semua perangkat — desktop, tablet, maupun smartphone.'],
            ['bi-tags',            '#e03131', 'Multi Kategori',    'Beragam topik dari teknologi, olahraga, politik, pendidikan, hingga hiburan.'],
        ];
        foreach ($features as [$icon, $color, $title, $desc]):
        ?>
        <div class="col-md-3 col-6">
            <div style="background:var(--white); border-radius:var(--radius); padding:24px 20px; box-shadow:var(--shadow-sm); text-align:center; height:100%;">
                <div style="width:52px;height:52px;background:<?= $color ?>20;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <i class="bi <?= $icon ?>" style="color:<?= $color ?>; font-size:20px;"></i>
                </div>
                <div style="font-size:14px; font-weight:800; color:var(--dark); margin-bottom:8px;"><?= $title ?></div>
                <p style="font-size:12.5px; color:var(--gray); margin:0; line-height:1.7;"><?= $desc ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tim / Kontak -->
    <div style="background:var(--dark); border-radius:var(--radius); padding:36px; color:#fff;">
        <div class="row align-items-center g-4">
            <div class="col-md-7">
                <h4 style="font-weight:800; color:#fff; margin-bottom:10px;">
                    <i class="bi bi-envelope-heart me-2" style="color:var(--red);"></i>Hubungi Kami
                </h4>
                <p style="color:#94a3b8; margin-bottom:16px; font-size:14.5px; line-height:1.7;">
                    Punya pertanyaan, saran, atau ingin bekerja sama? Tim redaksi kami siap membantu.
                </p>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px; color:#94a3b8; font-size:14px;">
                        <i class="bi bi-envelope" style="color:var(--red);"></i>
                        redaksi@newsportal.com
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; color:#94a3b8; font-size:14px;">
                        <i class="bi bi-telephone" style="color:var(--red);"></i>
                        (021) 1234-5678
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; color:#94a3b8; font-size:14px;">
                        <i class="bi bi-geo-alt" style="color:var(--red);"></i>
                        Jakarta, Indonesia
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="mailto:redaksi@newsportal.com"
                   style="background:var(--red); color:#fff; padding:12px 28px; border-radius:25px; font-weight:700; font-size:14px; display:inline-flex; align-items:center; gap:8px;">
                    <i class="bi bi-send"></i> Kirim Email
                </a>
            </div>
        </div>
    </div>

</div>

<?php include "includes/footer.php"; ?>
