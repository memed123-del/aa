<?php
session_start();
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

require_once 'produk.php';
$produk = getAllProduk();
$jumlah = count($_SESSION['keranjang']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Toko Baju Terpercaya</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="keranjang.php" class="btn-keranjang">
                        Keranjang
                        <?php if ($jumlah > 0) { ?>
                            <span class="badge"><?php echo $jumlah; ?></span>
                        <?php } ?>
                    </a>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                            <a href="admin.php" class="btn-keranjang">Admin</a>
                        <?php } ?>
                        <a href="profil.php" class="btn-keranjang">Profil</a>
                        <a href="riwayat.php" class="btn-keranjang">Riwayat</a>
                    <?php } else { ?>
                        <a href="login.php" class="btn-keranjang">Login</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h2 class="mb-4 text-center">Daftar Produk</h2>
        <div class="row">
            <?php 
            foreach ($produk as $item) { 
            ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-img">
                        <?php if ($item['gambar'] != '') { ?>
                            <img src="uploads/<?php echo $item['gambar']; ?>" style="max-width:100%; max-height:100%;">
                        <?php } else { ?>
                            Tidak ada gambar
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <h5><?php echo $item['nama']; ?></h5>
                        <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                        <form method="POST" action="tambah_keranjang.php">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="nama" value="<?php echo $item['nama']; ?>">
                            <input type="hidden" name="harga" value="<?php echo $item['harga']; ?>">
                            <button type="submit" class="btn-beli">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
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
