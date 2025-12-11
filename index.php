<?php
session_start();
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/style-selera.css" />
    <link rel="icon" type="image/x-icon" href="assets/img/icon-web.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Yeseva+One&display=swap"
      rel="stylesheet"
    />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Selera Rakyat</title>
  </head>
  <body>
    <div class="container">
      <header>
        <div class="header-left">
          <img src="assets/img/icon-web.png" alt="" />
          <a href="index.php"><h1>Selera Rakyat</h1></a>
        </div>
        <nav id="mobile-menu">
          <ul>
            <li><a href="index.php" class="active">Beranda</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
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
            <?php endif; ?>
            
          </ul>
        </nav>
        <div class="group" style="display: none;">
          </div>
      </header>

      <div class="slider-wrapper" id="home">
        <div class="text">
          <h1>Selamat Datang di <span>Selera Rakyat</span></h1>
          <p>Cita Rasa Nusantara, Kenangan Masa Lalu.</p>
          <a href="menu.php" class="btn-explore">Explore Menu</a>
        </div>
        <div class="slide" id="slide1"></div>
        <div class="slide" id="slide2"></div>
        <div class="slide" id="slide3"></div>
      </div>

      <section>
        <div class="about" id="about">
          <h2>Tentang Kami</h2>
          <p>
            Selera Rakyat adalah toko kue yang menyajikan berbagai pilihan kue
            jajanan tradisional dan modern dengan cita rasa autentik Indonesia.
            Mulai dari Gethuk, klepon, pastel, dan masih banyak lagi, semua
            dibuat dari bahan berkualitas dengan harga terjangkau. Nikmati
            perpaduan rasa klasik dan modern hanya di Selera Rakyat!
          </p>
        </div>

        <div class="menu" id="menu">
          <h2>Menu Favorit</h2>
          <div class="menu-items">
            
            <?php 
            // Ambil 3 produk pertama dari database buat contoh di home
            $ambil = $koneksi->query("SELECT * FROM products LIMIT 3"); 
            while($perproduk = $ambil->fetch_assoc()){ 
            ?>
            
            <div class="menu-item">
              <img src="assets/img/<?php echo $perproduk['gambar']; ?>" alt="<?php echo $perproduk['nama_produk']; ?>" style="height: 200px; object-fit: cover;">
              
              <h3><?php echo $perproduk['nama_produk']; ?></h3>
              <p><?php echo substr($perproduk['deskripsi'], 0, 500); ?></p>
            </div>

            <?php } ?>

          </div>
          <a href="menu.php"><button class="btn-more">Menu Selengkapnya</button></a>
        </div>

        <div class="promo">
          <h1>Promo Hari ini</h1>
          <section class="coupon">
            <div class="coupon-container">
              <div class="coupon-header">
                <h2>Diskon Akhir Pekan!</h2>
                <p>Dapatkan Potongan 15% untuk semua Jajanan Tradisional.</p>
              </div>
              <div class="coupon-body">
                <div class="coupon-code">
                  <h3>Kode Kupon</h3>
                  <p>SERU15</p>
                </div>
                <div class="coupon-details">
                  <p>Berlaku setiap hari Jumat - Minggu.</p>
                  <p>Minimal pembelian: Rp 80.000</p>
                </div>
              </div>
            </div>
            </section>
        </div>
      </section>

      <footer>
        <div class="main-footer">
          <div class="footer-left">
            <img src="assets/img/icon-web.png" alt="Selera Rakyat" />
            <h1>Selera Rakyat</h1>
          </div>
          <div class="footer-right">
            <a href="pages/error.html"><img src="assets/img/instagram.png" alt="Instagram" /></a>
            <a href="pages/error.html"><img src="assets/img/facebook.png" alt="Facebook" /></a>
            <a href="pages/error.html"><img src="assets/img/twitter.png" alt="Twitter" /></a>
            <a href="pages/error.html"><img src="assets/img/whatsapp.png" alt="WhatsApp" /></a>
            <a href="pages/error.html"><img src="assets/img/tiktok.png" alt="Tiktok" /></a>
            <a href="pages/error.html"><img src="assets/img/youtube.png" alt="Youtube" /></a>
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
    </script>
  </body>
</html>