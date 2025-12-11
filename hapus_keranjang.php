<?php
session_start();

$id_produk = $_GET["id"];

// Hapus item dari session array
unset($_SESSION["keranjang"][$id_produk]);

// echo "<script>alert('Produk dihapus dari keranjang');</script>";
echo "<script>location='keranjang.php';</script>";
?>