CREATE DATABASE IF NOT EXISTS db_karyawan
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE db_karyawan;

CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level ENUM('admin','petugas') NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS karyawan (
    id_karyawan INT AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(20) NOT NULL UNIQUE,
    nama_karyawan VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    departemen VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, nama_lengkap, level)
SELECT 'admin', '$2y$10$JfX3QddN5ZsttqP3c6QKUu3MRZ4OUdYxcs1./0Qfw2N2AeJevfY8K', 'Administrator', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username='admin');

INSERT INTO karyawan
(nik, nama_karyawan, jenis_kelamin, jabatan, departemen, alamat, no_hp, tanggal_masuk)
SELECT 'KRY001', 'Budi Santoso', 'Laki-laki', 'Staff Administrasi', 'Administrasi',
       'Mojokerto', '081234567890', '2026-01-10'
WHERE NOT EXISTS (SELECT 1 FROM karyawan WHERE nik='KRY001');
