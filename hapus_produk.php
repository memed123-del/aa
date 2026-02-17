<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM produk WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: daftar_produk.php');
        exit;
    }
}

header('Location: daftar_produk.php');
exit;
?>



