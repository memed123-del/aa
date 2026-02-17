==========================================
PANDUAN SETUP TOKO BAJU BUNGA
==========================================

CARA INSTALASI:

1. BUAT DATABASE MYSQL
   - Buka phpMyAdmin atau MySQL
   - Import file database.sql
   - Atau jalankan query di database.sql secara manual

2. SETTING KONEKSI DATABASE
   - Buka file config.php
   - Sesuaikan:
     * $host = 'localhost' (atau sesuai server Anda)
     * $username = 'root' (username MySQL Anda)
     * $password = '' (password MySQL Anda, kosongkan jika tidak ada)
     * $database = 'tokobajubunga' (nama database)

3. JALANKAN WEBSITE
   - Letakkan semua file di folder htdocs (XAMPP) atau www (WAMP)
   - Buka browser: http://localhost/nama-folder/index.php

4. LOGIN DEMO
   - Username: admin, Password: admin123
   - Username: user, Password: user123

STRUKTUR DATABASE:
- users: Data user/pelanggan
- produk: Data produk baju
- pesanan: Data pesanan
- detail_pesanan: Detail item dalam pesanan

FILE PENTING:
- config.php: Koneksi database
- database.sql: Struktur database
- index.php: Halaman utama
- produk.php: Fungsi produk
- login.php: Halaman login
- register.php: Halaman daftar
- keranjang.php: Keranjang belanja
- pembayaran.php: Halaman pembayaran
- riwayat.php: Riwayat pesanan

CATATAN:
- Pastikan MySQL sudah berjalan
- Pastikan database sudah dibuat dan diimport
- Sesuaikan koneksi di config.php

