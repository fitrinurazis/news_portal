-- =============================================
-- PERTEMUAN 11: Tabel Kategori & Artikel
-- =============================================

CREATE TABLE IF NOT EXISTS kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    isi_berita TEXT NOT NULL,
    thumbnail VARCHAR(255),
    kategori_id INT,
    user_id INT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh kategori
INSERT INTO kategori (nama_kategori) VALUES
('Teknologi'),
('Olahraga'),
('Politik'),
('Pendidikan'),
('Hiburan');
