<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$sql_pesanan = "SELECT COUNT(*) as total FROM pesanan";
$hasil_pesanan = mysqli_query($conn, $sql_pesanan);
$row_pesanan = mysqli_fetch_assoc($hasil_pesanan);
$total_pesanan = $row_pesanan['total'];

$sql_produk = "SELECT COUNT(*) as total FROM produk";
$hasil_produk = mysqli_query($conn, $sql_produk);
$row_produk = mysqli_fetch_assoc($hasil_produk);
$total_produk = $row_produk['total'];

$sql_user = "SELECT COUNT(*) as total FROM users";
$hasil_user = mysqli_query($conn, $sql_user);
$row_user = mysqli_fetch_assoc($hasil_user);
$total_user = $row_user['total'];

$sql_menunggu = "SELECT * FROM pesanan WHERE status = 'menunggu pembayaran' ORDER BY created_at DESC";
$hasil_menunggu = mysqli_query($conn, $sql_menunggu);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Panel Admin</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="index.php" class="btn-keranjang">← Kembali</a>
                    <a href="logout.php" class="btn-keranjang">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h2 class="mb-4">Dashboard Admin</h2>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-box">
                    <h3><?php echo $total_pesanan; ?></h3>
                    <p>Total Pesanan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <h3><?php echo $total_produk; ?></h3>
                    <p>Total Produk</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <h3><?php echo $total_user; ?></h3>
                    <p>Total User</p>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <a href="tambah_produk.php" class="admin-menu-item">
                    <span class="menu-icon">➕</span>
                    <div>
                        <strong>Tambah Produk</strong>
                        <p>Tambah produk baru ke toko</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="daftar_produk.php" class="admin-menu-item">
                    <span class="menu-icon">📦</span>
                    <div>
                        <strong>Daftar Produk</strong>
                        <p>Kelola produk yang ada</p>
                    </div>
                </a>
            </div>
        </div>

        <h3 class="mb-3">Pesanan Menunggu Approval</h3>
        <?php if (mysqli_num_rows($hasil_menunggu) == 0) { ?>
            <div class="alert alert-info">Tidak ada pesanan yang menunggu approval</div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pesanan = mysqli_fetch_assoc($hasil_menunggu)) { ?>
                        <tr>
                            <td>#<?php echo $pesanan['id']; ?></td>
                            <td><?php echo $pesanan['nama']; ?></td>
                            <td><?php echo $pesanan['telepon']; ?></td>
                            <td>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
                            <td>
                                <a href="detail_pesanan.php?id=<?php echo $pesanan['id']; ?>" class="btn-beli btn-sm">Detail</a>
                                <a href="approve_pesanan.php?id=<?php echo $pesanan['id']; ?>" class="btn-checkout btn-sm" onclick="return confirm('Approve pesanan ini?')">Approve</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </main>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Toko Baju Bunga. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



