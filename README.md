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
- Halaman **detail artikel** lengkap dengan sidebar
- **Pencarian artikel** berdasarkan judul & isi
- **Filter per kategori** dengan pagination
- **Sistem komentar** pada setiap artikel
- Halaman tentang portal

### 🔐 Admin Panel
- Login sistem dengan **session PHP** & **password hash**
- **Multi Role**: Ketua (akses penuh) & Admin (akses terbatas)
- **CRUD Kategori** berita
- **CRUD Artikel** + upload thumbnail
- **Rich Text Editor** (CKEditor 4) untuk penulisan artikel
- **Kelola User** khusus role Ketua

---

## 📁 Struktur Folder

```
newsportal/
├── index.php               # Homepage
├── detail.php              # Detail artikel
├── kategori.php            # Filter & search artikel
├── tentang.php             # Halaman tentang
├── auth/
│   └── login.php           # Halaman login
├── admin/
│   ├── dashboard.php       # Dashboard Ketua
│   ├── index.php           # Dashboard Admin
│   ├── user.php            # Kelola user
│   ├── kategori/           # CRUD kategori
│   └── artikel/            # CRUD artikel
├── config/
│   └── koneksi.php         # Koneksi database
├── includes/
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
├── assets/css/style.css    # Custom CSS
├── uploads/                # Thumbnail artikel
└── sql/                    # Script database
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

> **Catatan:** Hapus file `buat_user.php` setelah akun berhasil dibuat.

---

## 📸 Halaman Utama

| Halaman | URL |
|---------|-----|
| Homepage | `/newsportal/` |
| Kategori & Search | `/newsportal/kategori.php` |
| Detail Artikel | `/newsportal/detail.php?id=1` |
| Login Admin | `/newsportal/auth/login.php` |
| Dashboard | `/newsportal/admin/` |

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

---

## 👨‍💻 Developer

**fitrinurazis** — Pemrograman Web 2, 2026
