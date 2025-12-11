<?php
$ambil = $koneksi->query("SELECT * FROM products WHERE id='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$fotoproduk = $pecah['gambar'];

// Hapus foto dari folder jika ada
if (file_exists("../assets/img/$fotoproduk")) {
    unlink("../assets/img/$fotoproduk");
}

$koneksi->query("DELETE FROM products WHERE id='$_GET[id]'");
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
            text: 'Data produk berhasil dihapus.',
            icon: 'success',
            confirmButtonText: 'Oke',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            window.location = 'index.php?halaman=produk';
        });
    </script>
</body>
</html>