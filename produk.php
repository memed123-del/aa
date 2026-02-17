<?php
require_once 'config.php';

// Fungsi untuk mendapatkan produk by ID
function getProdukById($id) {
    global $conn;
    $query = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

// Fungsi untuk mendapatkan semua produk
function getAllProduk() {
    global $conn;
    $query = "SELECT * FROM produk ORDER BY id";
    $result = mysqli_query($conn, $query);
    $produk = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $produk[] = $row;
        }
    }
    return $produk;
}
?>

