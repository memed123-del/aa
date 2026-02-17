<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM produk ORDER BY id DESC";
$hasil = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Daftar Produk</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="tambah_produk.php" class="btn-beli">➕ Tambah Produk</a>
                    <a href="admin.php" class="btn-keranjang">← Kembali</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h2 class="mb-4">Daftar Semua Produk</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produk = mysqli_fetch_assoc($hasil)) { ?>
                    <tr>
                        <td><?php echo $produk['id']; ?></td>
                        <td><?php echo $produk['nama']; ?></td>
                        <td>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $produk['gambar']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($produk['created_at'])); ?></td>
                        <td>
                            <a href="hapus_produk.php?id=<?php echo $produk['id']; ?>" class="btn-hapus btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Toko Baju Bunga. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



