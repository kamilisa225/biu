<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-chart-bar me-2"></i>Laporan
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter Laporan -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="periode" class="form-label">Periode</label>
                <select class="form-select" id="periode" name="periode" onchange="toggleTanggal()">
                    <option value="hari_ini" <?php echo ($_GET['periode'] ?? '') == 'hari_ini' ? 'selected' : ''; ?>>Hari Ini</option>
                    <option value="kemarin" <?php echo ($_GET['periode'] ?? '') == 'kemarin' ? 'selected' : ''; ?>>Kemarin</option>
                    <option value="minggu_ini" <?php echo ($_GET['periode'] ?? '') == 'minggu_ini' ? 'selected' : ''; ?>>Minggu Ini</option>
                    <option value="bulan_ini" <?php echo ($_GET['periode'] ?? '') == 'bulan_ini' ? 'selected' : ''; ?>>Bulan Ini</option>
                    <option value="tahun_ini" <?php echo ($_GET['periode'] ?? '') == 'tahun_ini' ? 'selected' : ''; ?>>Tahun Ini</option>
                    <option value="custom" <?php echo ($_GET['periode'] ?? '') == 'custom' ? 'selected' : ''; ?>>Custom</option>
                </select>
            </div>
            
            <div class="col-md-3" id="customTanggal" style="<?php echo ($_GET['periode'] ?? '') == 'custom' ? '' : 'display: none;'; ?>">
                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?php echo $_GET['tgl_mulai'] ?? ''; ?>">
            </div>
            
            <div class="col-md-3" id="customTanggal2" style="<?php echo ($_GET['periode'] ?? '') == 'custom' ? '' : 'display: none;'; ?>">
                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="<?php echo $_GET['tgl_selesai'] ?? ''; ?>">
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-info me-2">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
                <button type="button" class="btn btn-success" onclick="cetakLaporan()">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>
        </form>
    </div>
</div>

<?php
// Ambil parameter filter
$periode = $_GET['periode'] ?? 'bulan_ini';
$tgl_mulai = $_GET['tgl_mulai'] ?? '';
$tgl_selesai = $_GET['tgl_selesai'] ?? '';

// Tentukan rentang tanggal berdasarkan periode
switch($periode) {
    case 'hari_ini':
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $periode_text = 'Hari Ini';
        break;
    case 'kemarin':
        $start_date = date('Y-m-d', strtotime('-1 day'));
        $end_date = date('Y-m-d', strtotime('-1 day'));
        $periode_text = 'Kemarin';
        break;
    case 'minggu_ini':
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d');
        $periode_text = 'Minggu Ini';
        break;
    case 'bulan_ini':
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        $periode_text = 'Bulan Ini';
        break;
    case 'tahun_ini':
        $start_date = date('Y-01-01');
        $end_date = date('Y-m-d');
        $periode_text = 'Tahun Ini';
        break;
    case 'custom':
        $start_date = $tgl_mulai ?: date('Y-m-01');
        $end_date = $tgl_selesai ?: date('Y-m-d');
        $periode_text = 'Custom';
        break;
    default:
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        $periode_text = 'Bulan Ini';
}

// Query untuk statistik
$query_stat = "SELECT 
    COUNT(*) as total_transaksi,
    SUM(CASE WHEN transaksi_status = '2' THEN transaksi_harga ELSE 0 END) as total_pendapatan,
    SUM(CASE WHEN transaksi_status = '2' THEN transaksi_berat ELSE 0 END) as total_berat,
    AVG(CASE WHEN transaksi_status = '2' THEN transaksi_harga ELSE NULL END) as rata_rata_transaksi
FROM transaksi 
WHERE transaksi_tgl BETWEEN '$start_date' AND '$end_date'";

$result_stat = mysqli_query($conn, $query_stat);
$stat = mysqli_fetch_assoc($result_stat);

// Query untuk transaksi per status
$query_status = "SELECT 
    transaksi_status,
    COUNT(*) as jumlah,
    SUM(transaksi_harga) as total_harga
FROM transaksi 
WHERE transaksi_tgl BETWEEN '$start_date' AND '$end_date'
GROUP BY transaksi_status";

$result_status = mysqli_query($conn, $query_status);
$status_data = [];
while($row = mysqli_fetch_assoc($result_status)) {
    $status_data[$row['transaksi_status']] = $row;
}

// Query untuk transaksi per hari
$query_harian = "SELECT 
    DATE(transaksi_tgl) as tanggal,
    COUNT(*) as jumlah_transaksi,
    SUM(CASE WHEN transaksi_status = '2' THEN transaksi_harga ELSE 0 END) as pendapatan
FROM transaksi 
WHERE transaksi_tgl BETWEEN '$start_date' AND '$end_date'
GROUP BY DATE(transaksi_tgl)
ORDER BY tanggal DESC
LIMIT 30";

$result_harian = mysqli_query($conn, $query_harian);
?>

<div class="row">
    <!-- Statistik Utama -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start border-primary border-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted fw-semibold">Total Transaksi</h6>
                        <h3 class="fw-bold"><?php echo $stat['total_transaksi'] ?? 0; ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-exchange-alt stat-icon text-primary"></i>
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
                        <h6 class="text-muted fw-semibold">Total Pendapatan</h6>
                        <h3 class="fw-bold">Rp <?php echo number_format($stat['total_pendapatan'] ?? 0, 0, ',', '.'); ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-money-bill-wave stat-icon text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start border-info border-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted fw-semibold">Total Berat</h6>
                        <h3 class="fw-bold"><?php echo number_format($stat['total_berat'] ?? 0, 1); ?> kg</h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-weight stat-icon text-info"></i>
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
                        <h6 class="text-muted fw-semibold">Rata-rata/Transaksi</h6>
                        <h3 class="fw-bold">Rp <?php echo number_format($stat['rata_rata_transaksi'] ?? 0, 0, ',', '.'); ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-chart-line stat-icon text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Harian -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h6 class="mb-0"><i class="fas fa-table me-2"></i>Detail Transaksi Harian (<?php echo $periode_text; ?>)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Transaksi</th>
                        <th>Pendapatan</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($result_harian) > 0) {
                        while($row = mysqli_fetch_assoc($result_harian)): 
                            $rata_rata = $row['jumlah_transaksi'] > 0 ? $row['pendapatan'] / $row['jumlah_transaksi'] : 0;
                    ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                        <td><?php echo $row['jumlah_transaksi']; ?></td>
                        <td>Rp <?php echo number_format($row['pendapatan'], 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($rata_rata, 0, ',', '.'); ?></td>
                    </tr>
                    <?php 
                        endwhile; 
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Tidak ada data transaksi</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function toggleTanggal() {
    var periode = document.getElementById('periode').value;
    var customTanggal = document.getElementById('customTanggal');
    var customTanggal2 = document.getElementById('customTanggal2');
    
    if(periode === 'custom') {
        customTanggal.style.display = 'block';
        customTanggal2.style.display = 'block';
    } else {
        customTanggal.style.display = 'none';
        customTanggal2.style.display = 'none';
    }
}

function cetakLaporan() {
    var periode = document.getElementById('periode').value;
    var tgl_mulai = document.getElementById('tgl_mulai').value;
    var tgl_selesai = document.getElementById('tgl_selesai').value;
    
    var url = 'laporan_print.php?periode=' + periode;
    if(periode === 'custom') {
        url += '&tgl_mulai=' + tgl_mulai + '&tgl_selesai=' + tgl_selesai;
    }
    
    window.open(url, '_blank');
}

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    // Trigger perubahan untuk menyesuaikan tampilan
    toggleTanggal();
});
</script>

<?php include 'footer.php'; ?>