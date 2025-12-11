<?php
session_start();
// Hapus semua session
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { 
            font-family: "Merriweather", serif; 
            background-color: #f8f4e1; 
        }
    </style>
</head>
<body>
    <script>
        Swal.fire({
            title: 'Berhasil Logout',
            text: 'Anda telah keluar dari sistem.',
            icon: 'success',
            confirmButtonText: 'Oke',
            confirmButtonColor: '#4e1f00' // Warna Coklat Khas Selera Rakyat
        }).then((result) => {
            // Setelah tombol Oke diklik atau alert ditutup, baru pindah ke index
            window.location = 'index.php';
        });
    </script>
</body>
</html>