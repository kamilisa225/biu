<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-plus-circle me-2"></i>Tambah Transaksi Baru
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="transaksi.php">Transaksi</a></li>
                <li class="breadcrumb-item active">Tambah Transaksi</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Form Transaksi Baru</h6>
    </div>
    <div class="card-body">
        <form action="transaksi_proses.php" method="POST" id="transaksiForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pelanggan" class="form-label">Pilih Pelanggan <span class="text-danger">*</span></label>
                    <select class="form-select" id="pelanggan" name="pelanggan" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $query = "SELECT * FROM pelanggan ORDER BY namapelanggan ASC";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_assoc($result)):
                        ?>
                        <option value="<?php echo $row['idpelanggan']; ?>">
                            <?php echo htmlspecialchars($row['namapelanggan']); ?> (<?php echo $row['hppelanggan']; ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="text-muted">Pelanggan belum terdaftar? <a href="pelanggan.php">Daftarkan disini</a></small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" 
                           min="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="berat" class="form-label">Berat (kg) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="berat" name="berat" 
                           step="0.1" min="0.1" placeholder="0.0" required onchange="hitungTotal()" onkeyup="hitungTotal()">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="harga_perkilo" class="form-label">Harga per Kilo</label>
                    <?php
                    $query = "SELECT harga_per_kilo FROM harga LIMIT 1";
                    $result = mysqli_query($conn, $query);
                    $harga = mysqli_fetch_assoc($result);
                    ?>
                    <input type="number" class="form-control" id="harga_perkilo" 
                           value="<?php echo $harga['harga_per_kilo']; ?>" readonly>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="text" class="form-control" id="total_harga" readonly>
                    <input type="hidden" id="transaksi_harga" name="transaksi_harga">
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
                            <!-- Baris pertama -->
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="jenis_pakaian[]" 
                                           placeholder="Contoh: Kaos, Celana, dll">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="jumlah_pakaian[]" 
                                           min="1" value="1">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusBaris(this)" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Catatan:</strong> Isi berat pakaian dengan benar. Harga akan dihitung otomatis berdasarkan berat dan harga per kilo.
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="transaksi.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Transaksi
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
            <input type="text" class="form-control" name="jenis_pakaian[]" 
                   placeholder="Contoh: Kaos, Celana, dll">
        </td>
        <td>
            <input type="number" class="form-control" name="jumlah_pakaian[]" 
                   min="1" value="1">
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
    
    // Set tanggal minimal untuk tanggal selesai (hari ini)
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('tgl_selesai').min = today;
    document.getElementById('tgl_selesai').value = today;
    
    // Validasi form
    document.getElementById('transaksiForm').addEventListener('submit', function(e) {
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