<?php
session_start();
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style-selera.css">
    <link rel="icon" type="image/x-icon" href="assets/img/icon-web.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Yeseva+One&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <title>Menu - Selera Rakyat</title>
</head>
<body>
    <div class="container">
      <header>
        <div class="header-left">
          <img src="assets/img/icon-web.png" alt="">
          <a href="index.php"><h1>Selera Rakyat</h1></a>
        </div>
        <nav>
          <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="menu.php" class="active">Menu</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <li style="color: #feba17;"> | </li>

            <?php if (isset($_SESSION["pelanggan"])): ?>
                <li class="user">
                    <a href="riwayat.php" style="color: #feba17; font-weight: bold;">
                        Halo, <?php echo $_SESSION["pelanggan"]["nama"]; ?>
                    </a>
                </li>
                <li><a href="logout.php" onclick="konfirmasiLogout(event)">Keluar</a></li>
            <?php else: ?>
                <li><a href="login.php">Masuk</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </header>

      <section>
        <div class="menus">
          <div class="background" id="menu"></div>
          
          <h1>Menu Kami</h1>
          
          <div class="menu-items">
            <?php 
            $ambil = $koneksi->query("SELECT * FROM products"); 
            while($perproduk = $ambil->fetch_assoc()){ 
            ?>
            
            <div class="menu-item">
              <img src="assets/img/<?php echo $perproduk['gambar']; ?>" alt="<?php echo $perproduk['nama_produk']; ?>" />
              
              <h3><?php echo $perproduk['nama_produk']; ?></h3>
              <p><?php echo substr($perproduk['deskripsi'], 0, 500); ?></p>  
              <h3 style="color: #4e1f00;">Rp <?php echo number_format($perproduk['harga']); ?></h3>
              
              <button class="btn-more" onclick="pesanProduk('<?php echo $perproduk['id']; ?>')">
                Pesan
              </button>
            </div>

            <?php } ?>
          </div>
        </div>
      </section>

      <footer>
        <div class="main-footer">
          <div class="footer-left">
            <img src="assets/img/icon-web.png" alt="Selera Rakyat">
            <h1>Selera Rakyat</h1>
          </div>
          <div class="footer-right">
            <a href="#"><img src="assets/img/instagram.png" alt="Instagram" /></a>
            <a href="#"><img src="assets/img/facebook.png" alt="Facebook" /></a>
            <a href="#"><img src="assets/img/twitter.png" alt="Twitter" /></a>
            <a href="#"><img src="assets/img/whatsapp.png" alt="WhatsApp" /></a>
            <a href="#"><img src="assets/img/tiktok.png" alt="Tiktok" /></a>
            <a href="#"><img src="assets/img/youtube.png" alt="Youtube" /></a>
          </div>
        </div>
        <div class="second-footer">
          <div class="second-footer-left">
            <p>Privacy Policy</p>
          </div>
          <div class="footer-right">
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="contact.php">Contact</a>
          </div>
        </div>
        <div style="margin-top: 2rem">
          <p class="copyright">
            Copyright &copy; <?php echo date("Y"); ?> All rights reserved
          </p>
        </div>
      </footer>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        // 1. Fungsi Logout
        function konfirmasiLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Sesi Anda akan berakhir.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e1f00',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }

        // 2. Fungsi Pesan Produk
        function pesanProduk(id) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Produk masuk ke keranjang',
                icon: 'success',
                timer: 1500, 
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'beli.php?id=' + id;
            });
        }
    </script>
</body>
</html>