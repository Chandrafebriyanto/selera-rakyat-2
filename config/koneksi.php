<?php
// Konfigurasi Database
$server   = "localhost";
$username = "root";      
$password = "";          
$database = "db_selera_rakyat"; 

// Membuat Koneksi
$koneksi = mysqli_connect($server, $username, $password, $database);

// Cek Koneksi (Opsional, buat ngetes doang)
if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
// echo "Koneksi Berhasil!"; // Hapus baris ini nanti kalau sudah fix
?>