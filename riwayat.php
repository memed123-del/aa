<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
} else {
    $user_id = NULL;
}

if ($user_id != NULL) {
    $sql = "SELECT * FROM pesanan WHERE user_id = '$user_id' ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM pesanan ORDER BY created_at DESC";
}

$hasil = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Riwayat Pesanan</p>
                </div>
                <a href="index.php" class="btn-keranjang">← Kembali</a>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h2 class="mb-4">Riwayat Pesanan Saya</h2>
        
        <?php if (!$hasil || mysqli_num_rows($hasil) == 0) { ?>
            <div class="text-center py-5">
                <h3>Belum Ada Pesanan</h3>
                <p>Anda belum pernah melakukan pembelian</p>
                <a href="index.php" class="btn-beli">Mulai Belanja</a>
            </div>
        <?php } else { ?>
            <?php 
            $no = 1;
            while ($pesanan = mysqli_fetch_assoc($hasil)) { 
                $pesanan_id = $pesanan['id'];
                $sql_detail = "SELECT * FROM detail_pesanan WHERE pesanan_id = '$pesanan_id'";
                $hasil_detail = mysqli_query($conn, $sql_detail);
            ?>
            <div class="pesanan-box mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4>Pesanan #<?php echo $pesanan['id']; ?></h4>
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
            </div>
            <?php 
                $no++;
            } 
            ?>
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

