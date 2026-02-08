<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-exchange-alt me-2"></i>Data Transaksi
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Transaksi</li>
            </ol>
        </nav>
    </div>
</div>

<?php
// Tampilkan pesan sukses/error
if(isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
    $alert_class = '';
    $icon = '';
    $message = '';
    
    switch($pesan) {
        case 'sukses_tambah':
            $alert_class = 'success';
            $icon = 'check-circle';
            $message = 'Transaksi berhasil ditambahkan!';
            break;
        case 'sukses_edit':
            $alert_class = 'success';
            $icon = 'check-circle';
            $message = 'Transaksi berhasil diperbarui!';
            break;
        case 'sukses_status':
            $alert_class = 'success';
            $icon = 'check-circle';
            $message = 'Status transaksi berhasil diperbarui!';
            break;
        case 'gagal':
            $alert_class = 'danger';
            $icon = 'exclamation-circle';
            $message = 'Terjadi kesalahan!';
            break;
    }
    
    if($message) {
        echo '<div class="alert alert-'.$alert_class.' alert-dismissible fade show">
                <i class="fas fa-'.$icon.' me-2"></i>'.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
?>

<!-- Filter Transaksi -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Transaksi</h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" 
                       value="<?php echo $_GET['tgl_mulai'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" 
                       value="<?php echo $_GET['tgl_selesai'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="0" <?php echo (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : ''; ?>>PROSES</option>
                    <option value="1" <?php echo (isset($_GET['status']) && $_GET['status'] == '1') ? 'selected' : ''; ?>>DICUCI</option>
                    <option value="2" <?php echo (isset($_GET['status']) && $_GET['status'] == '2') ? 'selected' : ''; ?>>SELESAI</option>
                    <option value="3" <?php echo (isset($_GET['status']) && $_GET['status'] == '3') ? 'selected' : ''; ?>>BATAL</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-info me-2">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="transaksi.php" class="btn btn-secondary">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
                <a href="transaksi_print.php?<?php echo http_build_query($_GET); ?>" 
                   target="_blank" class="btn btn-success ms-2">
                    <i class="fas fa-print me-1"></i> Cetak
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Transaksi</h6>
        <a href="transaksi_tambah.php" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i> Transaksi Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="transaksiTable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Tgl. Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Build WHERE clause for filtering
                    $where = [];
                    if(!empty($_GET['tgl_mulai']) && !empty($_GET['tgl_selesai'])) {
                        $where[] = "t.transaksi_tgl BETWEEN '{$_GET['tgl_mulai']}' AND '{$_GET['tgl_selesai']}'";
                    }
                    if(isset($_GET['status']) && $_GET['status'] !== '') {
                        $where[] = "t.transaksi_status = '{$_GET['status']}'";
                    }
                    
                    $where_sql = '';
                    if(count($where) > 0) {
                        $where_sql = 'WHERE ' . implode(' AND ', $where);
                    }
                    
                    $query = "SELECT t.*, p.namapelanggan 
                             FROM transaksi t 
                             JOIN pelanggan p ON t.transaksi_pelanggan = p.idpelanggan 
                             $where_sql 
                             ORDER BY t.transaksi_id DESC";
                    $result = mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $status = '';
                            switch($row['transaksi_status']) {
                                case '0': 
                                    $status = '<span class="badge bg-warning">PROSES</span>'; 
                                    break;
                                case '1': 
                                    $status = '<span class="badge bg-info">DICUCI</span>'; 
                                    break;
                                case '2': 
                                    $status = '<span class="badge bg-success">SELESAI</span>'; 
                                    break;
                                case '3': 
                                    $status = '<span class="badge bg-danger">BATAL</span>'; 
                                    break;
                            }                            
                            echo '<tr>
                                <td>
                                    <strong>INV-' . str_pad($row['transaksi_id'], 6, '0', STR_PAD_LEFT) . '</strong>
                                </td>
                                <td>' . date('d/m/Y', strtotime($row['transaksi_tgl'])) . '</td>
                                <td>' . htmlspecialchars($row['namapelanggan']) . '</td>
                                <td>' . $row['transaksi_berat'] . ' kg</td>
                                <td>Rp ' . number_format($row['transaksi_harga'], 0, ',', '.') . '</td>
                                <td>' . date('d/m/Y', strtotime($row['transaksi_tgl_selesai'])) . '</td>
                                <td>' . $status . '</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="transaksi_edit.php?id=' . $row['transaksi_id'] . '" 
                                           class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" class="text-center">Tidak ada data transaksi</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>