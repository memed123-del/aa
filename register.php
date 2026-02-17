<?php
session_start();
require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    
    if ($username == '' || $password == '' || $nama == '' || $email == '') {
        $error = 'Semua field harus diisi!';
    } else {
        $cek = "SELECT * FROM users WHERE username = '$username'";
        $hasil = mysqli_query($conn, $cek);
        
        if (mysqli_num_rows($hasil) > 0) {
            $error = 'Username sudah digunakan!';
        } else {
            $sql = "INSERT INTO users (username, password, nama, email) VALUES ('$username', '$password', '$nama', '$email')";
            
            if (mysqli_query($conn, $sql)) {
                $user_id = mysqli_insert_id($conn);
                $_SESSION['user'] = array();
                $_SESSION['user']['id'] = $user_id;
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['nama'] = $nama;
                $_SESSION['user']['email'] = $email;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Gagal mendaftar!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Toko Baju Bunga</h1>
                    <p>Halaman Daftar</p>
                </div>
                <a href="index.php" class="btn-keranjang">← Kembali</a>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-box">
                    <h2 class="text-center mb-4">Daftar Akun</h2>
                    
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    
                    <form method="POST" action="register.php">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn-beli w-100">Daftar</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
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

