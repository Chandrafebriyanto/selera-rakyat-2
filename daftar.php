<?php
session_start();
include 'config/koneksi.php';

// Siapkan variabel untuk menampung status notifikasi
$status = "";
$message = "";
$link = "";

// Jika tombol daftar ditekan
if (isset($_POST['daftar'])) {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $hp       = $_POST['no_hp'];
    $alamat   = $_POST['alamat'];

    // Cek apakah email sudah ada?
    $ambil = $koneksi->query("SELECT * FROM users WHERE email='$email'");
    if ($ambil->num_rows > 0) {
        // Jika email sudah ada -> Set status Error
        $status = "error";
        $message = "Pendaftaran Gagal, Email sudah digunakan!";
    } else {
        // Jika aman -> Enkripsi password & Simpan
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $koneksi->query("INSERT INTO users (nama, email, password, role, no_hp, alamat)
                         VALUES ('$nama', '$email', '$password_hash', 'user', '$hp', '$alamat')");

        // Set status Sukses & Redirect ke Login
        $status = "success";
        $message = "Pendaftaran Sukses, Silahkan Login!";
        $link = "login.php";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Selera Rakyat</title>
    <link rel="stylesheet" href="assets/css/style-selera.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container" style="margin-top: 20px; display: flex; justify-content: center;">
        <div class="card" style="width: 400px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; color: #4e1f00;">Daftar Akun</h2>
            
            <form method="post">
                <div style="margin-bottom: 10px;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="input" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Email</label>
                    <input type="email" name="email" class="input" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Password</label>
                    <input type="password" name="password" class="input" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" class="input" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="input" required style="width: 100%; height: 80px;"></textarea>
                </div>
                <button class="btn-more" name="daftar" style="width: 100%; background-color: #4e1f00; color: white;">Daftar</button>
            </form>
            
            <p style="text-align: center; margin-top: 10px;">Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>

    <?php if ($status != ""): ?>
        <script>
            Swal.fire({
                title: '<?php echo ($status == "success") ? "Berhasil!" : "Gagal!"; ?>',
                text: '<?php echo $message; ?>',
                icon: '<?php echo $status; ?>',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#4e1f00'
            }).then((result) => {
                // Jika sukses, pindahkan ke halaman Login
                <?php if ($link != ""): ?>
                    if (result.isConfirmed) {
                        window.location = '<?php echo $link; ?>';
                    }
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>