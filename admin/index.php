<?php
session_start();
include '../config/koneksi.php';

// Proteksi: Jika belum login atau BUKAN admin
if (!isset($_SESSION['pelanggan']) OR $_SESSION['pelanggan']['role'] != 'admin') {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Akses Ditolak</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Akses Ditolak!',
                text: 'Anda harus login sebagai admin untuk mengakses halaman ini.',
                icon: 'error',
                confirmButtonText: 'Login Sekarang',
                confirmButtonColor: '#d33'
            }).then((result) => {
                window.location = '../login.php';
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Selera Rakyat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Selera Rakyat</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?halaman=produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?halaman=pelanggan">Pelanggan</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?halaman=pembelian">Pembelian</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?halaman=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php 
        // Logic "Switch Halaman"
        if (isset($_GET['halaman'])) {
            
            // --- BAGIAN PRODUK ---
            if ($_GET['halaman'] == "produk") {
                include 'produk.php';
            }
            elseif ($_GET['halaman'] == "tambahproduk") {
                include 'tambahproduk.php';
            }
            elseif ($_GET['halaman'] == "hapusproduk") {
                include 'hapusproduk.php';
            }
            elseif ($_GET['halaman'] == "ubahproduk") {
                include 'ubahproduk.php';
            }
            
            // --- BAGIAN PELANGGAN ---
            elseif ($_GET['halaman'] == "pelanggan") {
                include 'pelanggan.php';
            }
            elseif ($_GET['halaman'] == "hapuspelanggan") {
                include 'hapuspelanggan.php';
            }
            
            // --- BAGIAN PEMBELIAN ---
            elseif ($_GET['halaman'] == "pembelian") {
                include 'pembelian.php';
            }
            elseif ($_GET['halaman'] == "detail") {
                include 'detail.php';
            }
            
            // --- BAGIAN LOGOUT (YANG DIUBAH) ---
            elseif ($_GET['halaman'] == "logout") {
                // 1. Hapus Session PHP
                session_destroy();
                
                // 2. Tampilkan SweetAlert langsung di sini
                echo "<script>
                    Swal.fire({
                        title: 'Logout Berhasil',
                        text: 'Anda telah keluar dari halaman admin.',
                        icon: 'success',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        // Redirect ke halaman login setelah klik Oke
                        window.location = '../login.php';
                    });
                </script>";
            }
            
        } else {
            // Halaman Default (Dashboard)
            include 'home.php';
        }
        ?>
    </div>

</body>
</html>