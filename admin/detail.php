<h2>Detail Pembelian</h2>

<?php
// AMBIL ID
$id_pembelian = $_GET['id'];

// QUERY DATA
$ambil = $koneksi->query("SELECT * FROM orders LEFT JOIN users ON orders.user_id=users.id WHERE orders.id='$id_pembelian'");
$detail = $ambil->fetch_assoc();

// VALIDASI DATA KOSONG
if (empty($detail)) {
    echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
    echo "<a href='index.php?halaman=pembelian' class='btn btn-secondary'>Kembali</a>";
    exit();
}
?>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white"><strong>Pembelian</strong></div>
            <div class="card-body">
                <strong>No. Pembelian: <?php echo $detail['id']; ?></strong><br>
                Tanggal: <?php echo date("d M Y", strtotime($detail['tanggal_pembelian'])); ?><br>
                Total: <strong>Rp <?php echo number_format($detail['total_pembelian']); ?></strong><br>
                Status: <span class="badge bg-warning text-dark"><?php echo ucfirst($detail['status_pembelian']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white"><strong>Pelanggan</strong></div>
            <div class="card-body">
                <strong><?php echo $detail['nama'] ?? 'User Terhapus'; ?></strong><br>
                <?php echo $detail['no_hp'] ?? '-'; ?><br>
                <?php echo $detail['email'] ?? '-'; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white"><strong>Pengiriman</strong></div>
            <div class="card-body">
                <?php echo $detail['alamat_pengiriman']; ?>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1; ?>
        <?php 
        $ambil = $koneksi->query("SELECT * FROM order_details LEFT JOIN products ON order_details.product_id=products.id WHERE order_details.order_id='$id_pembelian'"); 
        ?>
        <?php while($pecah=$ambil->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_produk'] ?? '<span class="text-danger">Produk Terhapus</span>'; ?></td>
            <td>Rp <?php echo number_format($pecah['harga'] ?? 0); ?></td>
            <td><?php echo $pecah['jumlah']; ?></td>
            <td>Rp <?php echo number_format(($pecah['harga'] ?? 0) * $pecah['jumlah']); ?></td>
        </tr>
        <?php $nomor++; } ?>
    </tbody>
</table>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><strong>Bukti Pembayaran</strong></div>
            <div class="card-body">
                <?php if (!empty($detail['bukti_pembayaran'])): ?>
                    <img src="../bukti_bayar/<?php echo $detail['bukti_pembayaran']; ?>" alt="Bukti Pembayaran" class="img-fluid rounded">
                <?php else: ?>
                    <div class="alert alert-danger">Belum ada bukti pembayaran</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><strong>Konfirmasi Status</strong></div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label>Ubah Status</label>
                        <select class="form-control" name="status">
                            <option value="">Pilih Status</option>
                            <option value="lunas">Lunas (Barang Dikemas)</option>
                            <option value="barang_dikirim">Barang Dikirim</option>
                            <option value="batal">Batal</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" name="proses">Update Status</button>
                </form>
                
                <?php 
                if (isset($_POST['proses'])) {
                    $status_baru = $_POST['status'];
                    $koneksi->query("UPDATE orders SET status_pembelian='$status_baru' WHERE id='$id_pembelian'");
                    
                    // Alert Sukses
                    echo "<script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status pesanan berhasil diperbarui',
                            icon: 'success',
                            confirmButtonText: 'Oke'
                        }).then((result) => {
                            window.location='index.php?halaman=pembelian';
                        });
                    </script>";
                }
                ?>
            </div>
        </div>
    </div>
</div>