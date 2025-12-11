<h2>Data Pembelian</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1; ?>
        <?php $ambil=$koneksi->query("SELECT *, orders.id AS id_order FROM orders JOIN users ON orders.user_id=users.id ORDER BY orders.tanggal_pembelian DESC"); ?>
        <?php while($pecah = $ambil->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama']; ?></td>
            <td><?php echo date("d F Y", strtotime($pecah['tanggal_pembelian'])); ?></td>
            <td>Rp <?php echo number_format($pecah['total_pembelian']); ?></td>
            <td><?php echo ucfirst($pecah['status_pembelian']); ?></td>
            <td>
                <a href="index.php?halaman=detail&id=<?php echo $pecah['id_order']; ?>" class="btn btn-info btn-sm text-white">Detail</a>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>