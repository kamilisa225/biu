<?php include 'header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-history me-2"></i>Log Aktivitas
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Log Aktivitas</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Log</h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" 
                       value="<?php echo $_GET['tanggal'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="admin" class="form-label">Admin</label>
                <select class="form-select" id="admin" name="admin">
                    <option value="">Semua Admin</option>
                    <?php
                    $query_admin = "SELECT * FROM admin_laundry ORDER BY namaadmin ASC";
                    $result_admin = mysqli_query($conn, $query_admin);
                    while($row = mysqli_fetch_assoc($result_admin)):
                    ?>
                    <option value="<?php echo $row['idadmin']; ?>" 
                        <?php echo (isset($_GET['admin']) && $_GET['admin'] == $row['idadmin']) ? 'selected' : ''; ?>>
                        <?php echo $row['namaadmin']; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-info me-2">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="log.php" class="btn btn-secondary">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Log Aktivitas</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="logTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Admin</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Build WHERE clause
                    $where = [];
                    if(!empty($_GET['tanggal'])) {
                        $where[] = "DATE(l.waktu) = '{$_GET['tanggal']}'";
                    }
                    if(!empty($_GET['admin'])) {
                        $where[] = "l.id_admin = '{$_GET['admin']}'";
                    }
                    
                    $where_sql = '';
                    if(count($where) > 0) {
                        $where_sql = 'WHERE ' . implode(' AND ', $where);
                    }
                    
                    $query = "SELECT l.*, a.namaadmin 
                             FROM log_aktivitas l 
                             LEFT JOIN admin_laundry a ON l.id_admin = a.idadmin 
                             $where_sql 
                             ORDER BY l.waktu DESC 
                             LIMIT 100";
                    $result = mysqli_query($conn, $query);
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <small><?php echo date('d/m/Y', strtotime($row['waktu'])); ?></small><br>
                            <small class="text-muted"><?php echo date('H:i:s', strtotime($row['waktu'])); ?></small>
                        </td>
                        <td><?php echo $row['namaadmin'] ?: 'System'; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php
                                $icon = 'info-circle';
                                $color = 'primary';
                                
                                if(strpos($row['aktivitas'], 'Login') !== false) {
                                    $icon = 'sign-in-alt';
                                    $color = 'success';
                                } elseif(strpos($row['aktivitas'], 'Logout') !== false) {
                                    $icon = 'sign-out-alt';
                                    $color = 'warning';
                                } elseif(strpos($row['aktivitas'], 'Menghapus') !== false) {
                                    $icon = 'trash';
                                    $color = 'danger';
                                } elseif(strpos($row['aktivitas'], 'Menambah') !== false) {
                                    $icon = 'plus-circle';
                                    $color = 'success';
                                } elseif(strpos($row['aktivitas'], 'Mengedit') !== false) {
                                    $icon = 'edit';
                                    $color = 'warning';
                                }
                                ?>
                                <i class="fas fa-<?php echo $icon; ?> text-<?php echo $color; ?> me-2"></i>
                                <span><?php echo $row['aktivitas']; ?></span>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo $_SERVER['REMOTE_ADDR']; ?></small>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>