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
                        $query = "SELECT COUNT(*) as total FROM transaksi 
                                 WHERE transaksi_tgl = CURDATE()";
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
                        $query = "SELECT COUNT(*) as total FROM transaksi 
                                 WHERE transaksi_status IN ('0', '1')";
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

<!-- Chart dan Tabel Terbaru -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik Transaksi 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <canvas id="transaksiChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status Transaksi</h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
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
                            while($row = mysqli_fetch_assoc($result)):
                                $status = '';
                                switch($row['transaksi_status']) {
                                    case '0': $status = '<span class="badge bg-warning">PROSES</span>'; break;
                                    case '1': $status = '<span class="badge bg-info">DICUCI</span>'; break;
                                    case '2': $status = '<span class="badge bg-success">SELESAI</span>'; break;
                                    case '3': $status = '<span class="badge bg-danger">BATAL</span>'; break;
                                }
                            ?>
                            <tr>
                                <td>INV-<?php echo str_pad($row['transaksi_id'], 6, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo $row['namapelanggan']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['transaksi_tgl'])); ?></td>
                                <td><?php echo $row['transaksi_berat']; ?> kg</td>
                                <td>Rp <?php echo number_format($row['transaksi_harga'], 0, ',', '.'); ?></td>
                                <td><?php echo $status; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Toggle Sidebar
document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('active');
});

// Chart Statistik Transaksi 7 Hari Terakhir
<?php
$labels = [];
$data = [];
for($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($date));
    
    $query = "SELECT COUNT(*) as total FROM transaksi WHERE transaksi_tgl = '$date'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $data[] = $row['total'];
}
?>

const ctx1 = document.getElementById('transaksiChart').getContext('2d');
const transaksiChart = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Jumlah Transaksi',
            data: <?php echo json_encode($data); ?>,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Chart Status Transaksi
<?php
$status_labels = ['PROSES', 'DICUCI', 'SELESAI', 'BATAL'];
$status_data = [];
$status_colors = ['#ffc107', '#17a2b8', '#28a745', '#dc3545'];

for($i = 0; $i <= 3; $i++) {
    $query = "SELECT COUNT(*) as total FROM transaksi WHERE transaksi_status = '$i'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $status_data[] = $row['total'];
}
?>

const ctx2 = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($status_labels); ?>,
        datasets: [{
            data: <?php echo json_encode($status_data); ?>,
            backgroundColor: <?php echo json_encode($status_colors); ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>