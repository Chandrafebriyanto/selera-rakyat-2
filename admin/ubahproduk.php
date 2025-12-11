<h2>Ubah Produk</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM products WHERE id='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="nama" class="form-control" value="<?php echo $pecah['nama_produk']; ?>">
    </div>
    <div class="mb-3">
        <label>Harga (Rp)</label>
        <input type="number" name="harga" class="form-control" value="<?php echo $pecah['harga']; ?>">
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" value="<?php echo $pecah['stok']; ?>">
    </div>
    <div class="mb-3">
        <label>Foto Saat Ini</label><br>
        <img src="../assets/img/<?php echo $pecah['gambar'] ?>" width="200">
    </div>
    <div class="mb-3">
        <label>Ganti Foto (Biarkan kosong jika tidak ingin mengganti)</label>
        <input type="file" name="foto" class="form-control">
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="5"><?php echo $pecah['deskripsi']; ?></textarea>
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>

<?php
if (isset($_POST['ubah']))
{
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    
    // Jika foto dirubah
    if (!empty($lokasifoto))
    {
        move_uploaded_file($lokasifoto, "../assets/img/$namafoto");

        $koneksi->query("UPDATE products SET 
            nama_produk='$_POST[nama]',
            harga='$_POST[harga]',
            stok='$_POST[stok]',
            gambar='$namafoto',
            deskripsi='$_POST[deskripsi]'
            WHERE id='$_GET[id]'");
    }
    else
    {
        $koneksi->query("UPDATE products SET 
            nama_produk='$_POST[nama]',
            harga='$_POST[harga]',
            stok='$_POST[stok]',
            deskripsi='$_POST[deskripsi]'
            WHERE id='$_GET[id]'");
    }
    
    // LOGIC ALERT DIGANTI KE SWEETALERT
    echo "<script>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data produk telah diubah',
            icon: 'success',
            confirmButtonText: 'Oke',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'index.php?halaman=produk';
            }
        })
    </script>";
}
?>