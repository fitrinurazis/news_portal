-- =============================================
-- PERTEMUAN 13: Tabel Komentar
-- =============================================

CREATE TABLE IF NOT EXISTS komentar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artikel_id INT,
    nama VARCHAR(100),
    email VARCHAR(100),
    komentar TEXT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
