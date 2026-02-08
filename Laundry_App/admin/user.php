<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-users-cog me-2"></i>Kelola Admin
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Admin</li>
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
        $message = 'Admin berhasil ditambahkan!';
    } elseif($pesan == 'sukses_edit') {
        $alert_class = 'success';
        $icon = 'check-circle';
        $message = 'Admin berhasil diperbarui!';
    } elseif($pesan == 'sukses_hapus') {
        $alert_class = 'success';
        $icon = 'check-circle';
        $message = 'Admin berhasil dihapus!';
    } elseif($pesan == 'gagal') {
        $alert_class = 'danger';
        $icon = 'exclamation-circle';
        $message = 'Terjadi kesalahan!';
    } elseif($pesan == 'akses_terlarang') {
        $alert_class = 'danger';
        $icon = 'exclamation-triangle';
        $message = 'Tidak dapat menghapus akun sendiri!';
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
        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Admin</h6>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
            <i class="fas fa-plus me-1"></i> Tambah Admin
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="adminTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM admin_laundry ORDER BY idadmin ASC";
                    $result = mysqli_query($conn, $query);
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['namaadmin']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'] ?? '2024-01-01')); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editAdminModal"
                                    data-id="<?php echo $row['idadmin']; ?>"
                                    data-username="<?php echo $row['namaadmin']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if($row['idadmin'] != $_SESSION['idadmin']): ?>
                            <a href="user_hapus.php?id=<?php echo $row['idadmin']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php else: ?>
                            <button class="btn btn-danger btn-sm" disabled title="Tidak dapat menghapus akun sendiri">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="user_tambah.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
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

<!-- Modal Edit Admin -->
<div class="modal fade" id="editAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="user_edit.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
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
// Handle modal edit
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editAdminModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var username = button.getAttribute('data-username');
        
        var modal = this;
        modal.querySelector('#edit_id').value = id;
        modal.querySelector('#edit_username').value = username;
    });
    
    // Validasi form tambah
    var tambahForm = document.querySelector('#tambahAdminModal form');
    tambahForm.addEventListener('submit', function(e) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        
        if(password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak sama!');
        }
    });
});
</script>

<?php include 'footer.php'; ?>