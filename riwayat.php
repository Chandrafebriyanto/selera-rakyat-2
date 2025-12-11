<?php
session_start();
include 'config/koneksi.php';

// Jika belum login, tidak boleh masuk sini
if (!isset($_SESSION["pelanggan"])) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>body { font-family: "Merriweather", serif; background-color: #f8f4e1; }</style>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Belum Login',
                text: 'Silahkan login terlebih dahulu untuk melihat riwayat.',
                icon: 'warning',
                confirmButtonText: 'Login',
                confirmButtonColor: '#4e1f00'
            }).then((result) => {
                window.location = 'login.php';
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
    <title>Riwayat Belanja - Selera Rakyat</title>
    <link rel="stylesheet" href="assets/css/style-selera.css">
    <link rel="icon" type="image/x-icon" href="assets/img/icon-web.png" />
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header style="background-color: #4e1f00;">
            <div class="header-left">
                <img src="assets/img/icon-web.png" alt="">
                <a href="index.php"><h1>Selera Rakyat</h1></a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="keranjang.php">Keranjang</a></li>
                    <li><a href="riwayat.php" class="active">Riwayat</a></li>
                    <li><a href="logout.php">Keluar</a></li>
                </ul>
            </nav>
        </header>

        <section class="riwayat">
            <h2>Riwayat Belanja <?php echo $_SESSION["pelanggan"]["nama"] ?></h2>
            <hr>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $nomor = 1;
                    $id_pelanggan = $_SESSION["pelanggan"]["id"];
                    
                    // Ambil semua order milik user ini
                    $ambil = $koneksi->query("SELECT * FROM orders WHERE user_id='$id_pelanggan' ORDER BY tanggal_pembelian DESC");
                    while($pecah = $ambil->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo date("d F Y", strtotime($pecah["tanggal_pembelian"])); ?></td>
                        <td>
                            <span style="font-weight: bold; color: <?php echo ($pecah['status_pembelian'] == 'pending') ? 'orange' : 'green'; ?>">
                                <?php echo ucfirst($pecah["status_pembelian"]); ?>
                            </span>
                        </td>
                        <td>Rp <?php echo number_format($pecah["total_pembelian"]); ?></td>
                        <td>
                            <a href="nota.php?id=<?php echo $pecah['id']; ?>">Nota</a>
                        </td>
                    </tr>
                    <?php $nomor++; } ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>