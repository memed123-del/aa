<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = '';
    
    if ($nama == '' || $harga == '') {
        $error = 'Nama dan harga harus diisi!';
    } else {
        if ($_FILES['gambar']['name'] != '') {
            $folder = 'uploads';
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $nama_file = time() . '_' . basename($_FILES['gambar']['name']);
            $tujuan = $folder . '/' . $nama_file;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan)) {
                $gambar = $nama_file;
            }
        }

        $sql = "INSERT INTO produk (nama, harga, gambar) VALUES ('$nama', '$harga', '$gambar')";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'Produk berhasil ditambahkan!';
        } else {
            $error = 'Gagal menambahkan produk!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><a href="index.php" class="header-link">Toko Baju Bunga</a></h1>
                    <p>Tambah Produk</p>
                </div>
                <a href="admin.php" class="btn-keranjang">← Kembali ke Admin</a>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h2 class="mb-4">Tambah Produk Baru</h2>
        
        <?php if ($error != '') { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        
        <?php if ($success != '') { ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php } ?>
        
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="tambah_produk.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk (upload)</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*">
                    </div>
                    <button type="submit" class="btn-beli">Tambah Produk</button>
                    <a href="admin.php" class="btn-keranjang ms-2">Batal</a>
                </form>
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



