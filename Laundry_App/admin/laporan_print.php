<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Statistik -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start border-primary border-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted fw-semibold">Total Pelanggan</h6>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM pelanggan";
                        $result = mysqli_query($conn, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="fw-bold"><?php echo $data['total']; ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-users stat-icon text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start border-success border-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted fw-semibold">Transaksi Hari Ini</h6>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM transaksi WHERE transaksi_tgl = CURDATE()";
                        $result = mysqli_query($conn, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="fw-bold"><?php echo $data['total']; ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-exchange-alt stat-icon text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start border-warning border-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted fw-semibold">Dalam Proses</h6>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM transaksi WHERE transaksi_status IN ('0', '1')";
                        $result = mysqli_query($conn, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="fw-bold"><?php echo $data['total']; ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-spinner stat-icon text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start border-danger border-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted fw-semibold">Pendapatan Bulan Ini</h6>
                        <?php
                        $query = "SELECT SUM(transaksi_harga) as total FROM transaksi 
                                 WHERE MONTH(transaksi_tgl) = MONTH(CURDATE()) 
                                 AND YEAR(transaksi_tgl) = YEAR(CURDATE())
                                 AND transaksi_status = '2'";
                        $result = mysqli_query($conn, $query);
                        $data = mysqli_fetch_assoc($result);
                        $total = $data['total'] ?: 0;
                        ?>
                        <h3 class="fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-money-bill-wave stat-icon text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="mb-3">Selamat Datang, <span class="text-primary"><?php echo $_SESSION['username']; ?></span>!</h4>
                <p class="mb-0">Selamat bekerja di Sistem Informasi Laundry. Gunakan menu di sidebar untuk mengelola data.</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-3 mb-4">
        <a href="transaksi_tambah.php" class="text-decoration-none">
            <div class="card text-center h-100 shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Tambah Transaksi</h5>
                    <p class="card-text text-muted">Input transaksi laundry baru</p>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-3 mb-4">
        <a href="pelanggan.php" class="text-decoration-none">
            <div class="card text-center h-100 shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Kelola Pelanggan</h5>
                    <p class="card-text text-muted">Lihat dan kelola data pelanggan</p>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-3 mb-4">
        <a href="transaksi.php" class="text-decoration-none">
            <div class="card text-center h-100 shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-list fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Lihat Transaksi</h5>
                    <p class="card-text text-muted">Lihat semua transaksi laundry</p>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-3 mb-4">
        <a href="laporan.php" class="text-decoration-none">
            <div class="card text-center h-100 shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Laporan</h5>
                    <p class="card-text text-muted">Lihat laporan dan statistik</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Transaksi Terbaru</h6>
                <a href="transaksi.php" class="btn btn-sm btn-light">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Berat</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT t.*, p.namapelanggan 
                                     FROM transaksi t 
                                     JOIN pelanggan p ON t.transaksi_pelanggan = p.idpelanggan 
                                     ORDER BY t.transaksi_id DESC LIMIT 5";
                            $result = mysqli_query($conn, $query);
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $status = '';
                                    switch($row['transaksi_status']) {
                                        case '0': $status = '<span class="badge bg-warning">PROSES</span>'; break;
                                        case '1': $status = '<span class="badge bg-info">DICUCI</span>'; break;
                                        case '2': $status = '<span class="badge bg-success">SELESAI</span>'; break;
                                        case '3': $status = '<span class="badge bg-danger">BATAL</span>'; break;
                                    }
                                    echo '<tr>
                                        <td>INV-' . str_pad($row['transaksi_id'], 6, '0', STR_PAD_LEFT) . '</td>
                                        <td>' . $row['namapelanggan'] . '</td>
                                        <td>' . date('d/m/Y', strtotime($row['transaksi_tgl'])) . '</td>
                                        <td>' . $row['transaksi_berat'] . ' kg</td>
                                        <td>Rp ' . number_format($row['transaksi_harga'], 0, ',', '.') . '</td>
                                        <td>' . $status . '</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">Belum ada transaksi</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>

<?php include 'footer.php'; ?>