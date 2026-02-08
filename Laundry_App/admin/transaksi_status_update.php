<?php
session_start();
require_once '../koneksi.php';

// Cek login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['transaksi_id'] ?? 0;
    $status = $_POST['transaksi_status'] ?? '0';
    
    if($id) {
        $query = "UPDATE transaksi SET transaksi_status = '$status' WHERE transaksi_id = '$id'";
        
        if(mysqli_query($conn, $query)) {
            // Log aktivitas
            $status_text = '';
            switch($status) {
                case '0': $status_text = 'PROSES'; break;
                case '1': $status_text = 'DICUCI'; break;
                case '2': $status_text = 'SELESAI'; break;
                case '3': $status_text = 'BATAL'; break;
            }
            
            $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                          VALUES ('{$_SESSION['idadmin']}', 'Mengubah status transaksi ID: $id menjadi $status_text')";
            mysqli_query($conn, $log_query);
            
            header("Location: transaksi.php?pesan=sukses_status");
        } else {
            header("Location: transaksi.php?pesan=gagal");
        }
    } else {
        header("Location: transaksi.php");
    }
} else {
    header("Location: transaksi.php");
}
exit();
?>