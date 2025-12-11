<h2>Tambah Produk</h2>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="mb-3">
        <label>Harga (Rp)</label>
        <input type="number" class="form-control" name="harga">
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" class="form-control" name="stok" min="1" value="1">
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="5"></textarea>
    </div>
    <div class="mb-3">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php 
if (isset($_POST['save']))
{
    $nama = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    
    // Upload foto
    move_uploaded_file($lokasi, "../assets/img/".$nama);
    
    // Insert DB
    $koneksi->query("INSERT INTO products 
        (nama_produk, harga, stok, gambar, deskripsi)
        VALUES('$_POST[nama]','$_POST[harga]','$_POST[stok]','$nama','$_POST[deskripsi]')");
    
    // GANTI BAGIAN INI:
    // Dulu: echo alert biasa
    // Sekarang: Pakai SweetAlert
    echo "<script>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data produk berhasil disimpan',
            icon: 'success',
            confirmButtonText: 'Oke'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'index.php?halaman=produk';
            }
        })
    </script>";
}
?>