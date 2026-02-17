-- Database untuk Toko Baju Bunga
-- Import file ini ke phpMyAdmin atau MySQL

CREATE DATABASE IF NOT EXISTS tokobajubunga;
USE tokobajubunga;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    gambar VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pesanan
CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    telepon VARCHAR(20) NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    total INT NOT NULL,
    status VARCHAR(50) DEFAULT 'menunggu pembayaran',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel Detail Pesanan
CREATE TABLE IF NOT EXISTS detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pesanan_id INT NOT NULL,
    produk_id INT NOT NULL,
    nama_produk VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal INT NOT NULL,
    FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE
);

-- Insert Data Produk
INSERT INTO produk (nama, harga, gambar) VALUES
('Baju Pink', 150000, 'baju1'),
('Baju Ungu', 175000, 'baju2'),
('Baju Putih', 160000, 'baju3'),
('Baju Pink Muda', 140000, 'baju4'),
('Baju Ungu Muda', 155000, 'baju5'),
('Baju Kombinasi', 180000, 'baju6');

-- Insert User Demo
INSERT INTO users (username, password, nama, email, role) VALUES
('admin', 'admin123', 'Admin', 'admin@tokobajubunga.com', 'admin'),
('user', 'user123', 'User', 'user@tokobajubunga.com', 'user');

