<?php
session_start();
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

require_once 'produk.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    
    $produk_data = getProdukById($id);
    
    if ($produk_data) {
        $item = array();
        $item['id'] = $produk_data['id'];
        $item['nama'] = $produk_data['nama'];
        $item['harga'] = $produk_data['harga'];
        $item['jumlah'] = 1;
        
        $ada = false;
        foreach ($_SESSION['keranjang'] as $key => $value) {
            if ($value['id'] == $id) {
                $_SESSION['keranjang'][$key]['jumlah'] = $_SESSION['keranjang'][$key]['jumlah'] + 1;
                $ada = true;
                break;
            }
        }
        
        if ($ada == false) {
            $_SESSION['keranjang'][] = $item;
        }
    }
}

header('Location: index.php');
exit;
?>

