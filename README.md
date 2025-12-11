# Selera Rakyat - Toko Online Jajanan Tradisional

**Selera Rakyat** adalah aplikasi web e-commerce berbasis PHP Native dan MySQL yang dirancang untuk penjualan jajanan tradisional dan kue. Aplikasi ini memiliki fitur lengkap mulai dari katalog produk, keranjang belanja, checkout, hingga panel admin untuk pengelolaan toko.

## 📋 Fitur Aplikasi

### Halaman Pengunjung (Frontend)
* **Katalog Menu:** Menampilkan daftar jajanan tradisional dengan harga dan foto.
* **Keranjang Belanja:** Menambah produk ke keranjang, update jumlah, dan hapus item.
* **Checkout:** Form pengiriman otomatis terisi data pelanggan, perhitungan total belanja.
* **Manajemen Akun:** Daftar akun baru dan Login pelanggan.
* **Riwayat Pesanan:** Memantau status pesanan dan melihat nota transaksi.
* **Upload Bukti Bayar:** Fitur untuk mengunggah bukti transfer pembayaran.

### Halaman Admin (Backend)
* **Dashboard:** Ringkasan navigasi admin.
* **Manajemen Produk:** Tambah, Edit, dan Hapus data produk (termasuk upload gambar).
* **Manajemen Pelanggan:** Melihat daftar pelanggan terdaftar dan menghapusnya.
* **Manajemen Pembelian:** Melihat pesanan masuk, detail item yang dibeli, dan alamat pengiriman.
* **Konfirmasi Pembayaran:** Memverifikasi bukti bayar dan mengubah status pesanan (Lunas/Dikirim/Batal).

## 🛠️ Persyaratan Sistem

* **Web Server:** Apache (via XAMPP, WAMP, atau MAMP).
* **Database:** MySQL / MariaDB.
* **Bahasa:** PHP (Versi 7.4 atau 8.x direkomendasikan).
* **Browser:** Google Chrome, Firefox, atau Edge.

## 🚀 Cara Instalasi & Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal (localhost):

### 1. Persiapan Folder
1.  Pastikan Anda sudah menginstal **XAMPP**.
2.  Salin folder proyek `selera-rakyat` ini.
3.  Tempelkan (Paste) folder tersebut ke dalam direktori `htdocs` di instalasi XAMPP Anda (biasanya di `C:\xampp\htdocs\`).
   
   *Struktur folder seharusnya menjadi:* `C:\xampp\htdocs\selera-rakyat\`

### 2. Membuat Database
1.  Buka aplikasi **XAMPP Control Panel** dan klik **Start** pada modul **Apache** dan **MySQL**.
2.  Buka browser dan akses ke `http://localhost/phpmyadmin`.
3.  Buat database baru dengan nama: **`db_selera_rakyat`**.
4.  Klik tab **SQL** pada database tersebut, lalu salin dan jalankan (Go) kode SQL di bawah ini untuk membuat tabel dan data awal:

```sql
-- 1. Tabel Users (Menyimpan data Admin dan Pelanggan)
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(25) NOT NULL,
    alamat TEXT,
    role ENUM('admin', 'user') DEFAULT 'user',
    PRIMARY KEY (id)
);

-- 2. Tabel Products (Menyimpan data Menu Jajanan)
CREATE TABLE products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama_produk VARCHAR(100) NOT NULL,
    harga INT(11) NOT NULL,
    stok INT(11) NOT NULL,
    gambar VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    PRIMARY KEY (id)
);

-- 3. Tabel Orders (Menyimpan data Transaksi Utama)
CREATE TABLE orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    tanggal_pembelian DATETIME NOT NULL,
    total_pembelian INT(11) NOT NULL,
    alamat_pengiriman TEXT NOT NULL,
    status_pembelian VARCHAR(50) DEFAULT 'pending',
    bukti_pembayaran VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id)
);

-- 4. Tabel Order Details (Menyimpan Rincian Barang per Transaksi)
CREATE TABLE order_details (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    jumlah INT(11) NOT NULL,
    PRIMARY KEY (id)
);

-- INSERT DATA DUMMY (CONTOH)

-- Akun Admin (Password: admin)
INSERT INTO users (nama, email, password, no_hp, role) 
VALUES ('Administrator', 'admin@gmail.com', 'admin', '08123456789', 'admin');

-- Akun Pelanggan (Password: user)
INSERT INTO users (nama, email, password, no_hp, alamat, role) 
VALUES ('Pelanggan Contoh', 'user@gmail.com', 'user', '08987654321', 'Jl. Kebon Jeruk No. 10, Jakarta', 'user');

-- Data Produk
INSERT INTO products (nama_produk, harga, stok, gambar, deskripsi) VALUES 
('Klepon', 5000, 20, 'klepon.jpg', 'Klepon isi gula merah lumer dengan taburan kelapa parut segar.'),
('Risol Mayo', 3000, 15, 'risol mayo.jpg', 'Risol renyah dengan isian mayonaise, telur rebus, dan daging asap.'),
('Brownies Kukus', 35000, 10, 'brownies.jpg', 'Brownies coklat kukus yang lembut dan manis pas di lidah.'),
('Pastel', 2500, 25, 'pastel.jpg', 'Pastel goreng isi sayuran dan telur puyuh yang gurih.');
```

### 3. Konfigurasi Koneksi (Opsional)
File konfigurasi database berada di config/koneksi.php. Jika Anda menggunakan password untuk MySQL (default XAMPP biasanya kosong), silakan edit file tersebut:
```php
$server   = "localhost";
$username = "root";      // Sesuaikan username database
$password = "";          // Sesuaikan password database
$database = "db_selera_rakyat";
```

### 4. Menjalankan Website
Buka browser dan akses alamat berikut:
* Halaman Utama (Toko): http://localhost/selera-rakyat/
* Halaman Login Admin: http://localhost/selera-rakyat/login.php (Login dengan akun admin akan otomatis diarahkan ke panel admin)

### 🔑 Akun Login Default
Gunakan akun berikut untuk mencoba aplikasi:
1. Akun Admin
* Email: admin@gmail.com
* Password: admin
2. Akun Pelanggan
* Email: user@gmail.com
* Password: user

### 📂 Struktur Proyek
```php
selera-rakyat/
├── admin/              # File-file halaman Admin (backend)
├── assets/             
│   ├── css/            # Stylesheet (style-selera.css)
│   ├── img/            # Aset gambar produk & ikon
│   └── js/             # Script Javascript
├── bukti_bayar/        # Direktori penyimpanan upload bukti bayar user
├── config/             # Koneksi database
├── index.php           # Halaman Beranda
├── menu.php            # Halaman Katalog Produk
├── keranjang.php       # Halaman Keranjang
├── checkout.php        # Halaman Checkout
├── login.php           # Halaman Login
├── daftar.php          # Halaman Registrasi
└── ...                 # File pendukung lainnya
```
