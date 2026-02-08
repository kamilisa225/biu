<?php
session_start();
require_once '../koneksi.php';

// Cek login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

// Ambil filter dari URL
$where = [];
if(!empty($_GET['tgl_mulai']) && !empty($_GET['tgl_selesai'])) {
    $where[] = "transaksi_tgl BETWEEN '".$_GET['tgl_mulai']."' AND '".$_GET['tgl_selesai']."'";
}
if(isset($_GET['status']) && $_GET['status'] !== '') {
    $where[] = "transaksi_status='".$_GET['status']."'";
}

$where_sql = count($where) > 0 ? "AND ".implode(' AND ', $where) : "";

// Ambil data transaksi sesuai filter
$query = "SELECT * FROM pelanggan, transaksi WHERE transaksi_pelanggan=idpelanggan $where_sql ORDER BY transaksi_id DESC";
$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { font-size: 12px; }
        }
        table { 
            font-size: 12px; 
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .badge {
            font-size: 11px;
            padding: 4px 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header">
            <h3>Laporan Transaksi Laundry</h3>
            <p>Periode: <?php 
                if(!empty($_GET['tgl_mulai']) && !empty($_GET['tgl_selesai'])) {
                    echo date('d/m/Y', strtotime($_GET['tgl_mulai'])) . ' - ' . date('d/m/Y', strtotime($_GET['tgl_selesai']));
                } else {
                    echo 'Semua Data';
                }
            ?></p>
            <p>Dicetak: <?php echo date('d/m/Y H:i:s'); ?></p>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Berat (kg)</th>
                    <th>Total</th>
                    <th>Tgl. Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total_berat = 0;
                $total_harga = 0;
                
                if(mysqli_num_rows($data) > 0) {
                    while($d = mysqli_fetch_assoc($data)) {
                        $status = '';
                        if($d['transaksi_status']=="0") $status = "PROSES";
                        elseif($d['transaksi_status']=="1") $status = "DICUCI";
                        elseif($d['transaksi_status']=="2") $status = "SELESAI";
                        elseif($d['transaksi_status']=="3") $status = "BATAL";
                        
                        $total_berat += $d['transaksi_berat'];
                        $total_harga += $d['transaksi_harga'];
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>INVOICE-<?php echo $d['transaksi_id']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($d['transaksi_tgl'])); ?></td>
                    <td><?php echo htmlspecialchars($d['namapelanggan']); ?></td>
                    <td><?php echo $d['transaksi_berat']; ?></td>
                    <td>Rp <?php echo number_format($d['transaksi_harga'], 0, ',', '.'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($d['transaksi_tgl_selesai'])); ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo '<tr><td colspan="8" class="text-center">Tidak ada data transaksi</td></tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td colspan="4" class="text-end">TOTAL:</td>
                    <td><?php echo number_format($total_berat, 2); ?> kg</td>
                    <td>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="8">
                        <small>Total Transaksi: <?php echo ($no - 1); ?></small>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">
            Cetak Laporan
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            Tutup
        </button>
    </div>

    <script>
        // Auto print saat halaman dimuat
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>
</html>