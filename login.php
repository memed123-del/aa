<?php
session_start();
require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $hasil = mysqli_query($conn, $sql);
    
    if ($hasil && mysqli_num_rows($hasil) > 0) {
        $user = mysqli_fetch_assoc($hasil);
        $_SESSION['user'] = array();
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['username'] = $user['username'];
        $_SESSION['user']['nama'] = $user['nama'];
        $_SESSION['user']['email'] = $user['email'];
        if (isset($user['role'])) {
            $_SESSION['user']['role'] = $user['role'];
        } else {
            $_SESSION['user']['role'] = 'user';
        }
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Baju Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Toko Baju Bunga</h1>
                    <p>Halaman Login</p>
                </div>
                <a href="index.php" class="btn-keranjang">← Kembali</a>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-box">
                    <h2 class="text-center mb-4">Login</h2>
                    
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    
                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn-beli w-100">Login</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
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

