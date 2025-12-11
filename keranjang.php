<?php
session_start();
include 'config/koneksi.php';

// LOGIC 1: CEK KERANJANG KOSONG DENGAN SWEETALERT
if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Keranjang Kosong</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>body { font-family: "Merriweather", serif; background-color: #f8f4e1; }</style>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Keranjang Kosong',
                text: 'Silahkan pilih menu favoritmu dulu ya!',
                icon: 'warning',
                confirmButtonText: 'Ke Menu',
                confirmButtonColor: '#4e1f00'
            }).then((result) => {
                window.location = 'menu.php';
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
    <title>Keranjang - Selera Rakyat</title>
    <link rel="stylesheet" href="assets/css/style-selera.css">
    <link rel="icon" type="image/x-icon" href="assets/img/icon-web.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Yeseva+One&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <li><a href="keranjang.php" class="active">Keranjang</a></li>
                    <li style="color: #feba17;"> | </li>

                    <?php if (isset($_SESSION["pelanggan"])): ?>
                <li class="user">
                    <a href="riwayat.php">
                        Halo, <?php echo $_SESSION["pelanggan"]["nama"]; ?>
                    </a>
                </li>
                <li><a href="logout.php" onclick="konfirmasiLogout(event)">Keluar</a></li>
            <?php else: ?>
                <li><a href="login.php">Masuk</a></li>
                <li><a href="daftar.php">Daftar</a></li>
            <?php endif; ?>
                </ul>
            </nav>
        </header>

        <section class="list-produk">
            <h1>Keranjang Belanjaan Anda</h1>
            <hr>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $nomor = 1;
                    $total_belanja = 0;
                    
                    foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): 
                        $ambil = $koneksi->query("SELECT * FROM products WHERE id='$id_produk'");
                        $pecah = $ambil->fetch_assoc();
                        
                        $subtotal = $pecah["harga"] * $jumlah;
                        $total_belanja += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td>
                            <div>
                                <img src="assets/img/<?php echo $pecah['gambar']; ?>" class="cart-img">
                                <strong><?php echo $pecah["nama_produk"]; ?></strong>
                            </div>
                        </td>
                        <td>Rp <?php echo number_format($pecah["harga"]); ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td>Rp <?php echo number_format($subtotal); ?></td>
                        <td>
                            <button onclick="hapusProduk('<?php echo $id_produk; ?>')" class="btn-danger">Hapus</button>
                        </td>
                    </tr>
                    <?php 
                        $nomor++; 
                    endforeach; 
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right; background: #fff; color: #4e1f00; font-size: 1.2rem;">Total Belanja :</th>
                        <th colspan="2" style="background: #fff; color: #d63384; font-size: 1.2rem;">Rp <?php echo number_format($total_belanja); ?></th>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 30px; display: flex; justify-content: space-between;">
                <a href="menu.php" class="btn-more" style="background: #6c757d; border-color: #6c757d;">&laquo; Lanjut Belanja</a>
                
                <?php if (isset($_SESSION["pelanggan"])): ?>
                    <a href="checkout.php" class="btn-primary" style="align-content: center;">Checkout Sekarang &raquo;</a>
                <?php else: ?>
                    <button onclick="alertLogin()" class="btn-primary" style="align-content: center;">Login untuk Checkout</button>
                <?php endif; ?>
            </div>

        </section>
    </div>

    <script>
        // Fungsi Hapus Produk
        function hapusProduk(id) {
            Swal.fire({
                title: 'Hapus produk?',
                text: "Produk ini akan dihapus dari keranjang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke file PHP hapus
                    window.location = 'hapus_keranjang.php?id=' + id;
                }
            })
        }

        // Fungsi Alert Login
        function alertLogin() {
            Swal.fire({
                title: 'Belum Login',
                text: "Anda harus login member untuk melakukan pembayaran.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4e1f00',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Login Sekarang',
                cancelButtonText: 'Nanti'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'login.php';
                }
            })
        }
    </script>
</body>
</html>