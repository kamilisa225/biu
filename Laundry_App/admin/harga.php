<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-tag me-2"></i>Pengaturan Harga
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan Harga</li>
            </ol>
        </nav>
    </div>
</div>

<?php
if(isset($_GET['pesan'])) {
    if($_GET['pesan'] == 'sukses') {
        echo '<div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>Harga berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    } elseif($_GET['pesan'] == 'gagal') {
        echo '<div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>Terjadi kesalahan!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}

// Ambil harga saat ini
$query = "SELECT * FROM harga LIMIT 1";
$result = mysqli_query($conn, $query);
$harga = mysqli_fetch_assoc($result);
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Atur Harga per Kilo</h6>
            </div>
            <div class="card-body">
                <form action="harga_update.php" method="POST">
                    <div class="mb-3">
                        <label for="harga_per_kilo" class="form-label">Harga per Kilo (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="harga_per_kilo" 
                                   name="harga_per_kilo" 
                                   value="<?php echo $harga['harga_per_kilo']; ?>" 
                                   min="0" required>
                        </div>
                        <small class="text-muted">Harga saat ini: Rp <?php echo number_format($harga['harga_per_kilo'], 0, ',', '.'); ?> per kg</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Estimasi Harga</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6>1 kg</h6>
                                        <h5 class="text-primary" id="estimasi1kg">Rp 0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6>3 kg</h6>
                                        <h5 class="text-primary" id="estimasi3kg">Rp 0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6>5 kg</h6>
                                        <h5 class="text-primary" id="estimasi5kg">Rp 0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Riwayat Perubahan Harga -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Perubahan Harga</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Harga Lama</th>
                                <th>Harga Baru</th>
                                <th>Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Note: Anda perlu menambahkan tabel riwayat_harga untuk fitur ini
                            // CREATE TABLE riwayat_harga (
                            //     id INT AUTO_INCREMENT PRIMARY KEY,
                            //     harga_lama INT,
                            //     harga_baru INT,
                            //     dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            //     dibuat_oleh INT
                            // );
                            ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Riwayat perubahan harga akan ditampilkan di sini
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function updateEstimasi() {
    var harga = parseInt(document.getElementById('harga_per_kilo').value) || 0;
    
    document.getElementById('estimasi1kg').textContent = formatRupiah(harga * 1);
    document.getElementById('estimasi3kg').textContent = formatRupiah(harga * 3);
    document.getElementById('estimasi5kg').textContent = formatRupiah(harga * 5);
}

document.addEventListener('DOMContentLoaded', function() {
    updateEstimasi();
    
    document.getElementById('harga_per_kilo').addEventListener('input', updateEstimasi);
});
</script>

<?php include 'footer.php'; ?>