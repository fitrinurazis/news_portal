# 📰 News Portal

Portal berita modern berbasis PHP Native + Bootstrap 5 + MySQL.

---

## 🛠️ Tech Stack

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap_5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![CKEditor](https://img.shields.io/badge/CKEditor_4-0287D0?style=for-the-badge&logo=ckeditor4&logoColor=white)

---

## ✨ Fitur

### 👤 Publik
- Homepage dinamis dengan **Hero News** & artikel per kategori
- Halaman **detail artikel** lengkap dengan sidebar populer & terkait
- **View counter** — jumlah pembaca di setiap artikel
- **Artikel populer** di sidebar berdasarkan jumlah views
- **Pencarian artikel** berdasarkan judul & isi
- **Filter per kategori** dengan pagination
- **Sistem komentar** pada setiap artikel
- Halaman **Tentang** dengan statistik portal live
- **Halaman 404** custom
- **Open Graph meta tags** untuk SEO & sharing media sosial
- **Lazy loading** gambar untuk performa lebih baik
- Tampilan **responsif penuh** di mobile & desktop

### 🔐 Admin Panel
- Login sistem dengan **session PHP** & **password hash**
- **Multi Role**: Ketua (akses penuh) & Admin (akses terbatas)
- Dashboard modern dengan stat cards, tabel artikel terbaru & komentar terbaru
- **CRUD Artikel** + upload thumbnail + CKEditor 4
- **CRUD Kategori** dengan form tambah cepat & jumlah artikel per kategori
- **Kelola Komentar** — lihat & hapus komentar dari semua artikel
- **Kelola User** khusus role Ketua (tambah, edit, hapus)
- **Sidebar responsif** — offcanvas di mobile, kolom tetap di desktop
- Active state menu sidebar otomatis sesuai halaman

### 🔒 Keamanan
- Proteksi **SQL Injection** dengan `mysqli_real_escape_string()` & casting `(int)`
- `buat_user.php` hanya bisa diakses jika belum ada user di database
- Password disimpan dengan **password_hash()**

---

## 📁 Struktur Folder

```
newsportal/
├── index.php               # Homepage
├── detail.php              # Detail artikel + view counter
├── kategori.php            # Filter & search artikel
├── tentang.php             # Halaman tentang
├── 404.php                 # Halaman error 404 custom
├── buat_user.php           # Setup akun pertama (hapus setelah pakai)
├── .htaccess               # Redirect 404 ke 404.php
├── auth/
│   └── login.php           # Halaman login
├── admin/
│   ├── dashboard.php       # Dashboard Ketua
│   ├── index.php           # Dashboard Admin/Editor
│   ├── user.php            # Kelola user (khusus Ketua)
│   ├── komentar.php        # Kelola komentar
│   ├── header.php          # Header & CSS admin panel
│   ├── sidebar.php         # Sidebar responsif + active detection
│   ├── footer.php          # Footer & JS admin panel
│   ├── kategori/           # CRUD kategori
│   └── artikel/            # CRUD artikel
├── config/
│   └── koneksi.php         # Koneksi database
├── includes/
│   ├── header.php          # Head HTML + Open Graph meta tags
│   ├── navbar.php          # Navbar responsif
│   └── footer.php          # Footer
├── assets/
│   └── css/style.css       # Custom CSS (responsif)
├── uploads/                # Thumbnail artikel
└── sql/
    ├── pertemuan09.sql     # Buat database newsportal_db
    ├── pertemuan10.sql     # Tabel users
    ├── pertemuan11.sql     # Tabel kategori & artikel
    ├── pertemuan13.sql     # Tabel komentar
    └── tambahan.sql        # Tambah kolom views di tabel artikel
```

---

## ⚙️ Instalasi

### 1. Clone repository
```bash
git clone https://github.com/fitrinurazis/news_portal.git
```
Letakkan di folder `C:\laragon\www\` atau `C:\xampp\htdocs\`

### 2. Buat database
Jalankan file SQL secara berurutan di phpMyAdmin:

| File | Keterangan |
|------|-----------|
| `sql/pertemuan09.sql` | Buat database `newsportal_db` |
| `sql/pertemuan10.sql` | Tabel `users` |
| `sql/pertemuan11.sql` | Tabel `kategori` & `artikel` |
| `sql/pertemuan13.sql` | Tabel `komentar` |
| `sql/tambahan.sql` | Kolom `views` untuk view counter |

### 3. Sesuaikan koneksi database
Edit `config/koneksi.php`:
```php
$host = "localhost";
$user = "root";
$pass = "";          // sesuaikan password MySQL kamu
$db   = "newsportal_db";
```

### 4. Buat akun admin
Akses sekali saja di browser:
```
http://localhost/newsportal/buat_user.php
```
> ⚠️ Halaman ini otomatis terkunci jika sudah ada user di database.

### 5. Jalankan aplikasi
```
http://localhost/newsportal
```

---

## 🔑 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Ketua | ketua@gmail.com | 12345 |
| Admin | admin@gmail.com | 12345 |

---

## 📸 Daftar Halaman

### Publik
| Halaman | URL |
|---------|-----|
| Homepage | `/newsportal/` |
| Kategori & Search | `/newsportal/kategori.php` |
| Detail Artikel | `/newsportal/detail.php?id=1` |
| Tentang | `/newsportal/tentang.php` |
| 404 | `/newsportal/404.php` |

### Admin
| Halaman | URL |
|---------|-----|
| Login | `/newsportal/auth/login.php` |
| Dashboard Ketua | `/newsportal/admin/dashboard.php` |
| Dashboard Admin | `/newsportal/admin/index.php` |
| Kelola Artikel | `/newsportal/admin/artikel/index.php` |
| Kelola Kategori | `/newsportal/admin/kategori/index.php` |
| Kelola Komentar | `/newsportal/admin/komentar.php` |
| Kelola User | `/newsportal/admin/user.php` |

---

## 📚 Pertemuan

Proyek ini dikerjakan bertahap dalam mata kuliah **Pemrograman Web 2**:

| Pertemuan | Materi |
|-----------|--------|
| 9 | Setup project, Bootstrap 5, koneksi database |
| 10 | Sistem login, session, multi role |
| 11 | Dashboard admin, CRUD kategori & artikel |
| 12 | Frontend dinamis, hero news, detail artikel |
| 13 | Halaman kategori, search, sistem komentar |
| 14 | Dashboard ketua, CRUD user, pagination, CKEditor |
| + | Redesign UI, keamanan, view counter, responsif, halaman komentar |

---

## 👨‍💻 Developer

**fitrinurazis** — Pemrograman Web 2, 2026
