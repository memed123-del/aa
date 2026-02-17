<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Toko Baju Bunga</h1>
                    <p>Profil Saya</p>
                </div>
                <a href="index.php" class="btn-keranjang">← Kembali</a>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="profil-box text-center">
                    <div class="profil-avatar"><?php echo strtoupper(substr($user['nama'], 0, 1)); ?></div>
                    <h3 class="mt-3"><?php echo $user['nama']; ?></h3>
                    <p class="text-muted"><?php echo $user['email']; ?></p>
                    <a href="logout.php" class="btn-hapus">Logout</a>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="profil-menu">
                    <a href="riwayat.php" class="menu-item">
                        <div>
                            <strong>Riwayat Pesanan</strong>
                            <p>Lihat semua pesanan Anda</p>
                        </div>
                    </a>
                    
                    <a href="keranjang.php" class="menu-item">
                        <div>
                            <strong>Keranjang Belanja</strong>
                            <p>Lihat produk di keranjang</p>
                        </div>
                    </a>
                    
                    <div class="menu-item">
                        <div>
                            <strong>Informasi Akun</strong>
                            <p>Username: <?php echo $user['username']; ?></p>
                        </div>
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



