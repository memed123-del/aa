<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM pesanan WHERE id = $id";
$hasil = mysqli_query($conn, $sql);
$pesanan = mysqli_fetch_assoc($hasil);

$sql_detail = "SELECT * FROM detail_pesanan WHERE pesanan_id = $id";
$hasil_detail = mysqli_query($conn, $sql_detail);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Detail Pesanan #<?php echo $pesanan['id']; ?></p>
                </div>
                <a href="admin.php" class="btn-keranjang">← Kembali</a>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <div class="pesanan-box">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3>Pesanan #<?php echo $pesanan['id']; ?></h3>
                    <p class="text-muted mb-0">Tanggal: <?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></p>
                </div>
                <span class="status-badge"><?php echo ucfirst($pesanan['status']); ?></span>
            </div>
            
            <div class="mb-3">
                <strong>Nama:</strong> <?php echo $pesanan['nama']; ?><br>
                <strong>Alamat:</strong> <?php echo $pesanan['alamat']; ?><br>
                <strong>Telepon:</strong> <?php echo $pesanan['telepon']; ?><br>
                <strong>Metode Pembayaran:</strong> <?php echo strtoupper($pesanan['metode_pembayaran']); ?>
            </div>
            
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($detail = mysqli_fetch_assoc($hasil_detail)) { ?>
                        <tr>
                            <td><?php echo $detail['nama_produk']; ?></td>
                            <td><?php echo $detail['jumlah']; ?></td>
                            <td>Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <?php if ($pesanan['status'] == 'menunggu pembayaran') { ?>
            <div class="text-end mt-3">
                <a href="approve_pesanan.php?id=<?php echo $pesanan['id']; ?>" class="btn-checkout" onclick="return confirm('Approve pesanan ini?')">Approve Pesanan</a>
            </div>
            <?php } ?>
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



