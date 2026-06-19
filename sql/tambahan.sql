-- Migrasi tambahan: kolom views untuk artikel
-- Jalankan sekali di phpMyAdmin

USE newsportal_db;

ALTER TABLE artikel ADD COLUMN views INT NOT NULL DEFAULT 0;
