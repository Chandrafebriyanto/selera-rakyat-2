<?php
$ambil = $koneksi->query("SELECT * FROM users WHERE id='$_GET[id]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM users WHERE id='$_GET[id]'");
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            title: 'Terhapus!',
            text: 'Data pelanggan berhasil dihapus.',
            icon: 'success',
            confirmButtonText: 'Oke',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            window.location = 'index.php?halaman=pelanggan';
        });
    </script>
</body>
</html>