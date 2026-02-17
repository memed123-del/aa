<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0) {
    header('Location: keranjang.php');
    exit;
}

$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total = $total + ($item['harga'] * $item['jumlah']);
}

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
} else {
    $user_id = NULL;
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $metode = $_POST['metode_pembayaran'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    
    if ($user_id != NULL) {
        $user_id_sql = $user_id;
    } else {
        $user_id_sql = "NULL";
    }
    
    $metode = mysqli_real_escape_string($conn, $metode);
    $nama = mysqli_real_escape_string($conn, $nama);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $telepon = mysqli_real_escape_string($conn, $telepon);

    $sql = "INSERT INTO pesanan (user_id, nama, alamat, telepon, metode_pembayaran, total, status) 
              VALUES ($user_id_sql, '$nama', '$alamat', '$telepon', '$metode', '$total', 'menunggu pembayaran')";
    
    if (mysqli_query($conn, $sql)) {
        $pesanan_id = mysqli_insert_id($conn);
        
        foreach ($_SESSION['keranjang'] as $item) {
            $subtotal = $item['harga'] * $item['jumlah'];
            $sql_detail = "INSERT INTO detail_pesanan (pesanan_id, produk_id, nama_produk, harga, jumlah, subtotal) 
                            VALUES ('$pesanan_id', '{$item['id']}', '{$item['nama']}', '{$item['harga']}', '{$item['jumlah']}', '$subtotal')";
            mysqli_query($conn, $sql_detail);
        }
        
        $_SESSION['keranjang'] = array();
        
        header('Location: riwayat.php');
        exit;
    } else {
        $error = 'Gagal menyimpan pesanan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Halaman Pembayaran</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="keranjang.php" class="btn-keranjang">← Kembali</a>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <a href="profil.php" class="btn-keranjang">Profil</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <?php if ($error != '') { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-4">Data Pengiriman</h2>
                    <form method="POST" action="pembayaran.php">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="telepon" required>
                        </div>

                        <h3 class="mb-3 mt-4">Metode Pembayaran</h3>
                        
                        <div class="metode-pembayaran">
                            <div class="metode-item">
                                <input type="radio" name="metode_pembayaran" value="cod" id="cod" required>
                                <label for="cod" class="metode-label">
                                    <div>
                                        <strong>COD (Cash On Delivery)</strong>
                                        <p>Bayar saat barang diterima</p>
                                    </div>
                                </label>
                            </div>

                            <div class="metode-item">
                                <input type="radio" name="metode_pembayaran" value="ewallet" id="ewallet">
                                <label for="ewallet" class="metode-label">
                                    <div>
                                        <strong>E-Wallet</strong>
                                        <p>GoPay, OVO, DANA, LinkAja</p>
                                    </div>
                                </label>
                            </div>

                            <div class="metode-item">
                                <input type="radio" name="metode_pembayaran" value="bank" id="bank">
                                <label for="bank" class="metode-label">
                                    <div>
                                        <strong>Transfer Bank</strong>
                                        <p>BCA, Mandiri, BRI, BNI</p>
                                    </div>
                                </label>
                            </div>

                            <div class="metode-item">
                                <input type="radio" name="metode_pembayaran" value="qris" id="qris">
                                <label for="qris" class="metode-label">
                                    <div>
                                        <strong>QRIS</strong>
                                        <p>Scan QR Code untuk pembayaran</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-checkout mt-4 w-100">Konfirmasi Pembayaran</button>
                    </form>
                </div>

                <div class="col-md-4">
                    <div class="summary-box">
                        <h3>Ringkasan Pesanan</h3>
                        <div class="summary-item">
                            <?php foreach ($_SESSION['keranjang'] as $item) { ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?php echo $item['nama']; ?> x<?php echo $item['jumlah']; ?></span>
                                <span>Rp <?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong class="total-harga">Rp <?php echo number_format($total, 0, ',', '.'); ?></strong>
                        </div>
                    </div>
                </div>
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

