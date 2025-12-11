<?php
session_start();
include 'config/koneksi.php';

// LOGIC 1: CEK LOGIN DENGAN SWEETALERT
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
                text: 'Silahkan login terlebih dahulu untuk checkout.',
                icon: 'warning',
                confirmButtonText: 'Login Sekarang',
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

// LOGIC 2: CEK KERANJANG KOSONG
if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) {
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
                title: 'Keranjang Kosong',
                text: 'Wah, keranjangmu masih kosong. Yuk belanja dulu!',
                icon: 'info',
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
    <title>Checkout - Selera Rakyat</title>
    <link rel="stylesheet" href="assets/css/style-selera.css">
    <link rel="icon" type="image/x-icon" href="assets/img/icon-web.png">
    
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
                    <li><a href="keranjang.php">Keranjang</a></li>
                    <li><a href="#" class="active">Checkout</a></li>
                </ul>
            </nav>
        </header>

        <section class="list-produk">
            <h1>Konfirmasi Pembayaran</h1>
            <hr>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
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
                        <td><?php echo $pecah["nama_produk"]; ?></td>
                        <td>Rp <?php echo number_format($pecah["harga"]); ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td>Rp <?php echo number_format($subtotal); ?></td>
                    </tr>
                    <?php $nomor++; endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right; padding: 10px;">Total Tagihan:</th>
                        <th style="padding: 10px; color: #d63384;">Rp <?php echo number_format($total_belanja); ?></th>
                    </tr>
                </tfoot>
            </table>

            <form method="post" style="margin-top: 20px;">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label>Nama Pelanggan</label>
                        <input type="text" readonly value="<?php echo $_SESSION["pelanggan"]["nama"] ?>" class="input" style="width: 100%;">
                    </div>
                    <div style="flex: 1;">
                        <label>Nomor HP</label>
                        <input type="text" readonly value="<?php echo $_SESSION["pelanggan"]["no_hp"] ?>" class="input" style="width: 100%;">
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <label>Alamat Pengiriman Lengkap</label>
                    <textarea name="alamat_pengiriman" class="input" style="width: 100%; height: 100px; color: #4e1f00" placeholder="Masukkan alamat lengkap pengiriman (termasuk Kode Pos)"><?php echo $_SESSION["pelanggan"]["alamat"]; ?></textarea>
                </div>
                
                <button class="btn-more" name="checkout" style="margin-top: 20px; width: 100%; background-color: #28a745; color: white;">Buat Pesanan</button>
            </form>

            <?php 
            if (isset($_POST["checkout"])) {
                $id_pelanggan = $_SESSION["pelanggan"]["id"];
                $tanggal_pembelian = date("Y-m-d H:i:s");
                $alamat_pengiriman = $_POST["alamat_pengiriman"];

                // 1. Simpan data ke tabel orders
                $koneksi->query("INSERT INTO orders (user_id, tanggal_pembelian, total_pembelian, alamat_pengiriman) 
                                VALUES ('$id_pelanggan', '$tanggal_pembelian', '$total_belanja', '$alamat_pengiriman')");

                // Mendapatkan ID order yang barusan terjadi
                $id_pembelian_barusan = $koneksi->insert_id;

                // 2. Simpan rincian produk ke tabel order_details
                foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
                    $koneksi->query("INSERT INTO order_details (order_id, product_id, jumlah) 
                                    VALUES ('$id_pembelian_barusan', '$id_produk', '$jumlah')");
                }

                // 3. Kosongkan keranjang belanja
                unset($_SESSION["keranjang"]);

                // 4. TAMPILKAN SWEETALERT SUKSES DAN REDIRECT
                echo "<script>
                    Swal.fire({
                        title: 'Pembelian Sukses!',
                        text: 'Terima kasih, pesanan Anda sedang diproses.',
                        icon: 'success',
                        confirmButtonText: 'Lihat Nota',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        // Redirect ke halaman Nota
                        window.location = 'nota.php?id=$id_pembelian_barusan';
                    });
                </script>";
            }
            ?>
        </section>
    </div>
</body>
</html>