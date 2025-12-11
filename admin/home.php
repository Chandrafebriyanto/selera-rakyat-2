<h2 class="mt-3">Selamat Datang, <?php echo $_SESSION['pelanggan']['nama']; ?></h2>
<p class="lead">Ini adalah ruang kendali untuk mengelola toko Selera Rakyat.</p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5 class="card-title">Produk</h5>
                <p class="card-text">Kelola menu makanan.</p>
                <a href="index.php?halaman=produk" class="btn btn-light btn-sm">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5 class="card-title">Pelanggan</h5>
                <p class="card-text">Data pembeli terdaftar.</p>
                <a href="index.php?halaman=pelanggan" class="btn btn-light btn-sm">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark mb-3">
            <div class="card-body">
                <h5 class="card-title">Pembelian</h5>
                <p class="card-text">Laporan pesanan masuk.</p>
                <a href="index.php?halaman=pembelian" class="btn btn-light btn-sm">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>