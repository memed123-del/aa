<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "UPDATE pesanan SET status = 'telah diterima' WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

header('Location: admin.php');
exit;
?>



