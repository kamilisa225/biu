<?php 
include 'header.php';

$id = $_GET['id'] ?? 0;

if(!$id) {
    header("Location: transaksi.php");
    exit();
}

$query = "SELECT t.*, p.namapelanggan 
          FROM transaksi t 
          JOIN pelanggan p ON t.transaksi_pelanggan = p.idpelanggan 
          WHERE t.transaksi_id = '$id'";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

if(!$transaksi) {
    header("Location: transaksi.php");
    exit();
}
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-edit me-2"></i>Edit Transaksi
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="transaksi.php">Transaksi</a></li>
                <li class="breadcrumb-item active">Edit Transaksi</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header bg-warning text-white">
        <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Form Edit Transaksi</h6>
    </div>
    <div class="card-body">
        <form action="transaksi_update.php" method="POST" id="editTransaksiForm">
            <input type="hidden" name="transaksi_id" value="<?php echo $id; ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pelanggan" class="form-label">Pilih Pelanggan <span class="text-danger">*</span></label>
                    <select class="form-select" id="pelanggan" name="pelanggan" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $query_pelanggan = "SELECT * FROM pelanggan ORDER BY namapelanggan ASC";
                        $result_pelanggan = mysqli_query($conn, $query_pelanggan);
                        while($row = mysqli_fetch_assoc($result_pelanggan)):
                        ?>
                        <option value="<?php echo $row['idpelanggan']; ?>" 
                            <?php echo ($row['idpelanggan'] == $transaksi['transaksi_pelanggan']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['namapelanggan']); ?> (<?php echo $row['hppelanggan']; ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" 
                           value="<?php echo $transaksi['transaksi_tgl_selesai']; ?>" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="berat" class="form-label">Berat (kg) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="berat" name="berat" 
                           step="0.1" min="0.1" value="<?php echo $transaksi['transaksi_berat']; ?>" 
                           required onchange="hitungTotal()" onkeyup="hitungTotal()">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="harga_perkilo" class="form-label">Harga per Kilo</label>
                    <?php
                    $query_harga = "SELECT harga_per_kilo FROM harga LIMIT 1";
                    $result_harga = mysqli_query($conn, $query_harga);
                    $harga = mysqli_fetch_assoc($result_harga);
                    ?>
                    <input type="number" class="form-control" id="harga_perkilo" 
                           value="<?php echo $harga['harga_per_kilo']; ?>" readonly>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="text" class="form-control" id="total_harga" 
                           value="Rp <?php echo number_format($transaksi['transaksi_harga'], 0, ',', '.'); ?>" readonly>
                    <input type="hidden" id="transaksi_harga" name="transaksi_harga" 
                           value="<?php echo $transaksi['transaksi_harga']; ?>">
                </div>
            </div>
            
            <!-- Daftar Pakaian -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6><i class="fas fa-tshirt me-2"></i>Daftar Pakaian</h6>
                    <button type="button" class="btn btn-sm btn-primary" onclick="tambahBaris()">
                        <i class="fas fa-plus me-1"></i> Tambah Baris
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="tabelPakaian">
                        <thead>
                            <tr>
                                <th width="70%">Jenis Pakaian</th>
                                <th width="20%">Jumlah</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pakaianBody">
                            <?php
                            $query_pakaian = "SELECT * FROM pakaian WHERE pakaian_transaksi = '$id'";
                            $result_pakaian = mysqli_query($conn, $query_pakaian);
                            
                            if(mysqli_num_rows($result_pakaian) > 0) {
                                while($row = mysqli_fetch_assoc($result_pakaian)):
                            ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="jenis_pakaian[]" 
                                           value="<?php echo htmlspecialchars($row['pakaian_jenis']); ?>">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="jumlah_pakaian[]" 
                                           min="1" value="<?php echo $row['pakaian_jumlah']; ?>">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusBaris(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; } else { ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="jenis_pakaian[]">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="jumlah_pakaian[]" min="1" value="1">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusBaris(this)" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status Transaksi <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="0" <?php echo ($transaksi['transaksi_status'] == '0') ? 'selected' : ''; ?>>PROSES</option>
                        <option value="1" <?php echo ($transaksi['transaksi_status'] == '1') ? 'selected' : ''; ?>>DICUCI</option>
                        <option value="2" <?php echo ($transaksi['transaksi_status'] == '2') ? 'selected' : ''; ?>>SELESAI</option>
                        <option value="3" <?php echo ($transaksi['transaksi_status'] == '3') ? 'selected' : ''; ?>>BATAL</option>
                    </select>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Catatan:</strong> Perubahan berat akan mengubah total harga secara otomatis.
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="transaksi.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Update Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function hitungTotal() {
    var berat = parseFloat(document.getElementById('berat').value) || 0;
    var hargaPerKilo = parseFloat(document.getElementById('harga_perkilo').value) || 0;
    var total = berat * hargaPerKilo;
    
    document.getElementById('total_harga').value = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('transaksi_harga').value = total;
}

function tambahBaris() {
    var tbody = document.getElementById('pakaianBody');
    var newRow = tbody.insertRow();
    
    newRow.innerHTML = `
        <td>
            <input type="text" class="form-control" name="jenis_pakaian[]">
        </td>
        <td>
            <input type="number" class="form-control" name="jumlah_pakaian[]" min="1" value="1">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusBaris(this)">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
}

function hapusBaris(btn) {
    var row = btn.parentNode.parentNode;
    var tbody = row.parentNode;
    
    if(tbody.rows.length > 1) {
        tbody.deleteRow(row.rowIndex - 1);
    }
}

// Hitung total saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    hitungTotal();
    
    // Validasi form
    document.getElementById('editTransaksiForm').addEventListener('submit', function(e) {
        var berat = parseFloat(document.getElementById('berat').value) || 0;
        var pelanggan = document.getElementById('pelanggan').value;
        
        if(!pelanggan) {
            e.preventDefault();
            alert('Silakan pilih pelanggan!');
            return false;
        }
        
        if(berat <= 0) {
            e.preventDefault();
            alert('Berat harus lebih dari 0 kg!');
            return false;
        }
        
        // Cek minimal ada 1 pakaian
        var jenisPakaian = document.getElementsByName('jenis_pakaian[]');
        var hasData = false;
        for(var i = 0; i < jenisPakaian.length; i++) {
            if(jenisPakaian[i].value.trim() !== '') {
                hasData = true;
                break;
            }
        }
        
        if(!hasData) {
            e.preventDefault();
            alert('Silakan isi minimal 1 jenis pakaian!');
            return false;
        }
    });
});
</script>

<?php include 'footer.php'; ?>