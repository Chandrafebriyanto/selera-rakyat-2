<h2>Data Produk</h2>

<a href="index.php?halaman=tambahproduk" class="btn btn-primary mb-3">Tambah Data</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Foto</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1; ?>
        <?php $ambil=$koneksi->query("SELECT * FROM products"); ?>
        <?php while($pecah = $ambil->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_produk']; ?></td>
            <td>Rp <?php echo number_format($pecah['harga']); ?></td>
            <td>
                <img src="../assets/img/<?php echo $pecah['gambar']; ?>" width="100">
            </td>
            <td><?php echo $pecah['stok']; ?></td>
            <td>
                <a href="#" onclick="hapusProduk('<?php echo $pecah['id']; ?>')" class="btn-danger btn btn-sm">Hapus</a>
                
                <a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id']; ?>" class="btn-warning btn btn-sm">Ubah</a>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>

<script>
    function hapusProduk(id) {
        Swal.fire({
            title: 'Yakin hapus produk?',
            text: "Data produk akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik Ya, baru arahkan ke link penghapusan PHP
                window.location = 'index.php?halaman=hapusproduk&id=' + id;
            }
        })
    }
</script>