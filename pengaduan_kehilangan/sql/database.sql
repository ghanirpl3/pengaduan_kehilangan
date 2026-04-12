-- =============================================
-- Database: Sistem Pengaduan Kehilangan Barang Siswa
-- =============================================

CREATE DATABASE IF NOT EXISTS db_pengaduan_kehilangan_siswa;
USE db_pengaduan_kehilangan_siswa;

-- =============================================
-- Table: admin
-- =============================================
DROP TABLE IF EXISTS aspirasi;
DROP TABLE IF EXISTS input_aspirasi;
DROP TABLE IF EXISTS siswa;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS admin;

CREATE TABLE IF NOT EXISTS admin (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: kategori
-- =============================================
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT PRIMARY KEY AUTO_INCREMENT,
    ket_kategori VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: siswa
-- =============================================
CREATE TABLE IF NOT EXISTS siswa (
    nis INT PRIMARY KEY,
    nama_siswa VARCHAR(50) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: input_aspirasi (Pengaduan)
-- =============================================
CREATE TABLE IF NOT EXISTS input_aspirasi (
    id_pelaporan INT PRIMARY KEY AUTO_INCREMENT,
    nis INT NOT NULL,
    id_kategori INT NOT NULL,
    kelas VARCHAR(100) NOT NULL,
    isi_text TEXT NOT NULL,
    isi_gambar VARCHAR(255),
    tanggal DATE NOT NULL,
    FOREIGN KEY (nis) REFERENCES siswa(nis) ON DELETE CASCADE,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: aspirasi (Status & Feedback)
-- =============================================
CREATE TABLE IF NOT EXISTS aspirasi (
    id_aspirasi INT PRIMARY KEY AUTO_INCREMENT,
    id_pelaporan INT NOT NULL,
    status ENUM('Menunggu', 'Proses', 'Selesai') DEFAULT 'Menunggu',
    tanggal DATE NOT NULL,
    id_admin INT,
    feedback TEXT,
    FOREIGN KEY (id_pelaporan) REFERENCES input_aspirasi(id_pelaporan) ON DELETE CASCADE,
    FOREIGN KEY (id_admin) REFERENCES admin(id_admin) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Sample Data
-- =============================================

-- Insert Admin
-- Username: admin, Password: admin123
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$xLRsOQwGNbREj3CkSXGNYuvDa.wC9qB4VH1qQqMB0iNJXxbQNrHNm');

-- Insert Kategori
INSERT INTO kategori (ket_kategori) VALUES 
('Elektronik'),
('Buku/Alat Tulis'),
('Pakaian'),
('Tas/Dompet'),
('Aksesoris'),
('Lainnya');

-- Insert Sample Siswa
-- NIS: 12001, Password: 12001
-- NIS: 12002, Password: 12002
-- NIS: 12003, Password: 12003
INSERT INTO siswa (nis, nama_siswa, kelas, password) VALUES 
(12001, 'Ahmad Fauzi', 'XII-IPA-1', '$2y$10$EOVF2V5dYk8E8QJDvS0M8eYzqJqG0cK0WmQCRxHCxFLqH7GlGqQXy'),
(12002, 'Siti Nurhaliza', 'XII-IPA-2', '$2y$10$k2qZpGzg9EwZJWQJPMN5wuCEHQMBkpCXQX9qz0pGz0qEJMN5wuCEH'),
(12003, 'Budi Santoso', 'XI-IPS-1', '$2y$10$M5wuCEHQMBkpCXQX9qz0pGz0qEJMN5wuCEHQMBkpCXQX9qz0pGz0q');
