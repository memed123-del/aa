<?php
session_start();
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total = $total + ($item['harga'] * $item['jumlah']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Keranjang Belanja</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="index.php" class="btn-keranjang">← Kembali</a>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <a href="profil.php" class="btn-keranjang">Profil</a>
                    <?php } else { ?>
                        <a href="login.php" class="btn-keranjang">Login</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <?php if (count($_SESSION['keranjang']) == 0) { ?>
            <div class="text-center py-5">
                <h3>Keranjang Kosong</h3>
                <p>Belum ada produk di keranjang Anda</p>
                <a href="index.php" class="btn-beli">Mulai Belanja</a>
            </div>
        <?php } else { ?>
            <h2 class="mb-4">Isi Keranjang</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($_SESSION['keranjang'] as $key => $item) { 
                            $subtotal = $item['harga'] * $item['jumlah'];
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $item['nama']; ?></td>
                            <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $item['jumlah']; ?></td>
                            <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            <td>
                                <a href="hapus_keranjang.php?id=<?php echo $key; ?>" class="btn-hapus">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            $no++;
                        } 
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>Rp <?php echo number_format($total, 0, ',', '.'); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-end mt-4">
                <a href="index.php" class="btn-beli me-2">Lanjut Belanja</a>
                <a href="pembayaran.php" class="btn-checkout">Checkout</a>
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

