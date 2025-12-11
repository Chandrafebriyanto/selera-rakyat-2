<?php
session_start();
include 'config/koneksi.php';

$id_order = $_GET['id'];

$ambil = $koneksi->query("SELECT * FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = '$id_order'");
$detail = $ambil->fetch_assoc();

$id_pelanggan_beli = $detail["user_id"];
$id_pelanggan_login = $_SESSION["pelanggan"]["id"];

if ($id_pelanggan_beli !== $id_pelanggan_login && $_SESSION["pelanggan"]["role"] !== 'admin') {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Akses Ilegal!',
                text: 'Anda tidak memiliki hak untuk melihat nota ini.',
                icon: 'error',
                confirmButtonText: 'Kembali',
                confirmButtonColor: '#d33'
            }).then((result) => {
                window.location = 'riwayat.php';
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
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="assets/css/style-selera.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container" style="padding-top: 50px; max-width: 800px; margin: auto;">
        <h2 style="color: #4e1f00; text-align: center;">Nota Pembelian</h2>
        
        <?php if ($detail['status_pembelian'] == "pending"): ?>
            <div class="alert-warning">
                Silahkan melakukan pembayaran sebesar <strong>Rp <?php echo number_format($detail['total_pembelian']); ?></strong><br>
                <strong>BANK BCA 123-456-789 a.n. Selera Rakyat</strong>
            </div>
        <?php else: ?>
            <div class="alert-info">
                Status Pesanan: <strong><?php echo ucfirst($detail['status_pembelian']); ?></strong>
            </div>
        <?php endif; ?>

        <div class="nota-box">
            <div class="row">
                <div>
                    <strong>No. Pembelian:</strong> #<?php echo $detail['id']; ?><br>
                    <strong>Tanggal:</strong> <?php echo date("d F Y, H:i", strtotime($detail['tanggal_pembelian'])); ?><br>
                    <strong>Total:</strong> Rp <?php echo number_format($detail['total_pembelian']); ?>
                </div>
                <div>
                    <strong>Pelanggan:</strong> <?php echo $detail['nama']; ?><br>
                    <strong>Telepon:</strong> <?php echo $detail['no_hp']; ?>
                </div>
            </div>
        </div>

        <table class="nota">
            <thead style="background: #4e1f00; color: white;">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $nomor = 1;
                $ambil_produk = $koneksi->query("SELECT * FROM order_details JOIN products ON order_details.product_id = products.id WHERE order_details.order_id = '$id_order'");
                while($produk = $ambil_produk->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $produk['nama_produk']; ?></td>
                    <td>Rp <?php echo number_format($produk['harga']); ?></td>
                    <td><?php echo $produk['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($produk['harga'] * $produk['jumlah']); ?></td>
                </tr>
                <?php $nomor++; } ?>
            </tbody>
        </table>

        <?php if ($detail['status_pembelian'] == "pending"): ?>
            <div style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
                <h3 style="color: #4e1f00;">Kirim Bukti Pembayaran</h3>
                <p>Kirim bukti transfer Anda disini agar pesanan segera diproses.</p>
                
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="bukti" class="input" style="border: 1px solid #ccc; padding: 5px; width: 100%; margin-bottom: 10px;" required>
                    <button class="btn-more" name="kirim" style="background: #28a745; color: white; width: 100%;">Kirim Bukti</button>
                </form>
            </div>
        <?php else: ?>
            <div style="text-align: center; margin-bottom: 20px;">
                <p>Anda sudah mengirimkan bukti pembayaran.</p>
                <img src="bukti_bayar/<?php echo $detail['bukti_pembayaran']; ?>" alt="Bukti Bayar" style="max-width: 300px; border-radius: 10px; border: 1px solid #ddd;">
            </div>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <a href="riwayat.php" class="btn-more" style="background: #4e1f00; color: white;">Kembali ke Riwayat</a>
        </div>
    </div>

    <?php 
    if (isset($_POST["kirim"])) {
        $namabukti = $_FILES["bukti"]["name"];
        $lokasibukti = $_FILES["bukti"]["tmp_name"];
        
        $namafiks = date("YmdHis").$namabukti;
        
        move_uploaded_file($lokasibukti, "bukti_bayar/$namafiks");

        $koneksi->query("UPDATE orders SET bukti_pembayaran='$namafiks', status_pembelian='sudah kirim pembayaran' WHERE id='$id_order'");

        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Bukti pembayaran terkirim. Tunggu konfirmasi admin ya!',
                icon: 'success',
                confirmButtonColor: '#4e1f00'
            }).then((result) => {
                window.location='nota.php?id=$id_order';
            });
        </script>";
    }
    ?>
</body>
</html>