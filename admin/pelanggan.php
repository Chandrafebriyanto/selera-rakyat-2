<h2>Data Pelanggan</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1; ?>
        <?php $ambil=$koneksi->query("SELECT * FROM users WHERE role='user'"); ?>
        <?php while($pecah = $ambil->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama']; ?></td>
            <td><?php echo $pecah['email']; ?></td>
            <td><?php echo $pecah['no_hp']; ?></td>
            <td>
                <a href="#" onclick="konfirmasiHapus('<?php echo $pecah['id']; ?>')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>

<script>
function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Yakin mau hapus?',
        text: "Data pelanggan ini akan hilang selamanya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kalau user klik Ya, baru arahkan ke link hapus
            window.location = 'index.php?halaman=hapuspelanggan&id=' + id;
        }
    })
}
</script>