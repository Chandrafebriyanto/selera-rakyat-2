<?php
session_start();

// Mendapatkan ID produk dari URL (baris link tombol pesan)
$id_produk = $_GET['id'];

// Jika sudah ada produk itu di keranjang, maka jumlahnya di +1
if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk] += 1;
} 
// Jika belum ada di keranjang, maka dianggap beli 1
else {
    $_SESSION['keranjang'][$id_produk] = 1;
}

// Larikan ke halaman keranjang
// echo "<script>alert('Produk telah masuk ke keranjang belanja');</script>";
echo "<script>location='menu.php';</script>";
?>