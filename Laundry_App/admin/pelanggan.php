<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-users me-2"></i>Data Pelanggan
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
        </nav>
    </div>
</div>

<?php
if(isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
    $alert_class = '';
    $icon = '';
    
    if($pesan == 'sukses_tambah') {
        $alert_class = 'success';
        $icon = 'check-circle';
        $message = 'Pelanggan berhasil ditambahkan!';
    } elseif($pesan == 'sukses_edit') {
        $alert_class = 'success';
        $icon = 'check-circle';
        $message = 'Pelanggan berhasil diperbarui!';
    } elseif($pesan == 'sukses_hapus') {
        $alert_class = 'success';
        $icon = 'check-circle';
        $message = 'Pelanggan berhasil dihapus!';
    } elseif($pesan == 'gagal') {
        $alert_class = 'danger';
        $icon = 'exclamation-circle';
        $message = 'Terjadi kesalahan!';
    }
    
    if(isset($alert_class)) {
        echo '<div class="alert alert-'.$alert_class.' alert-dismissible fade show">
                <i class="fas fa-'.$icon.' me-2"></i>'.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
?>

<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Pelanggan</h6>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPelangganModal">
            <i class="fas fa-plus me-1"></i> Tambah Pelanggan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="pelangganTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Tanggal Bergabung</th>
                        <th>Total Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT p.*, COUNT(t.transaksi_id) as total_transaksi 
                             FROM pelanggan p 
                             LEFT JOIN transaksi t ON p.idpelanggan = t.transaksi_pelanggan 
                             GROUP BY p.idpelanggan 
                             ORDER BY p.idpelanggan DESC";
                    $result = mysqli_query($conn, $query);
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['namapelanggan']; ?></td>
                        <td><?php echo substr($row['alamat'], 0, 50) . '...'; ?></td>
                        <td><?php echo $row['hppelanggan']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td><span class="badge bg-info"><?php echo $row['total_transaksi']; ?> transaksi</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editPelangganModal"
                                    data-id="<?php echo $row['idpelanggan']; ?>"
                                    data-nama="<?php echo $row['namapelanggan']; ?>"
                                    data-alamat="<?php echo $row['alamat']; ?>"
                                    data-telepon="<?php echo $row['hppelanggan']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="pelanggan_hapus.php?id=<?php echo $row['idpelanggan']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="tambahPelangganModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Pelanggan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="pelanggan_tambah.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pelanggan -->
<div class="modal fade" id="editPelangganModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Pelanggan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="pelanggan_edit.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nama" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="edit_telepon" name="telepon" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Handle modal edit pelanggan
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editPelangganModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        var alamat = button.getAttribute('data-alamat');
        var telepon = button.getAttribute('data-telepon');
        
        var modal = this;
        modal.querySelector('#edit_id').value = id;
        modal.querySelector('#edit_nama').value = nama;
        modal.querySelector('#edit_alamat').value = alamat;
        modal.querySelector('#edit_telepon').value = telepon;
    });
});
</script>

<?php include 'footer.php'; ?>