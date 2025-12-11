<?php
session_start();
include 'config/koneksi.php';

// Siapkan variabel status kosong
$status = "";
$message = "";
$link = "";

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $ambil = $koneksi->query("SELECT * FROM users WHERE email='$email'");
    
    if ($ambil->num_rows == 1) {
        $akun = $ambil->fetch_assoc();

        if (password_verify($password, $akun['password']) || $password == $akun['password']) {
            $_SESSION['pelanggan'] = $akun;
            
            // Set status SUKSES
            $status = "success";
            $message = "Login Berhasil!";
            
            // Tentukan arah redirect
            if ($akun['role'] == "admin") {
                $link = "admin/index.php";
            } else {
                $link = "index.php";
            }
        } else {
            // Set status GAGAL (Password Salah)
            $status = "error";
            $message = "Password Salah!";
        }
    } else {
        // Set status GAGAL (Email Tidak Ada)
        $status = "error";
        $message = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Selera Rakyat</title>
    <link rel="stylesheet" href="assets/css/style-selera.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .container{
            margin-top: 100px; 
            display: flex; 
            justify-content: center;
        }
        .card{
            width: 400px; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2{
            text-align: center; 
            color: #4e1f00;
        }
        .btn-more{
            margin-top: 15px;
            width: 100%; 
            background-color: #4e1f00; 
            color: white;
        }
        .register{
            text-align: center; 
            margin-top: 10px;
        }
        .register a{
            color: #feba17;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Login</h2>
            <form method="post">
                <div >
                    <label>Email</label>
                    <input type="email" name="email" class="input" required>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" class="input" required>
                </div>
                <button class="btn-more" name="login">Masuk</button>
            </form>
            <p class="register">Belum punya akun? <a href="daftar.php">Daftar</a></p>
        </div>
    </div>

    <?php if ($status != ""): ?>
        <script>
            Swal.fire({
                title: 'Notifikasi',
                text: '<?php echo $message; ?>',
                icon: '<?php echo $status; ?>',
                confirmButtonColor: '#4e1f00' 
            }).then((result) => {
                <?php if ($status == "success"): ?>
                    window.location = '<?php echo $link; ?>';
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>