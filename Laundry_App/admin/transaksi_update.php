<?php
session_start();
require_once '../koneksi.php';

// Cek login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    if(empty($_POST['transaksi_id']) || empty($_POST['pelanggan']) || empty($_POST['berat']) || empty($_POST['tgl_selesai']) || empty($_POST['status'])) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location: transaksi.php");
        exit();
    }
    
    $transaksi_id = mysqli_real_escape_string($conn, $_POST['transaksi_id']);
    $pelanggan = mysqli_real_escape_string($conn, $_POST['pelanggan']);
    $berat = mysqli_real_escape_string($conn, $_POST['berat']);
    $tgl_selesai = mysqli_real_escape_string($conn, $_POST['tgl_selesai']);
    $transaksi_harga = mysqli_real_escape_string($conn, $_POST['transaksi_harga']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $jenis_pakaian = $_POST['jenis_pakaian'] ?? [];
    $jumlah_pakaian = $_POST['jumlah_pakaian'] ?? [];
    
    // Validasi data
    if($berat <= 0) {
        $_SESSION['error'] = "Berat harus lebih dari 0 kg!";
        header("Location: transaksi_edit.php?id=$transaksi_id");
        exit();
    }
    
    if(empty($jenis_pakaian)) {
        $_SESSION['error'] = "Minimal isi 1 jenis pakaian!";
        header("Location: transaksi_edit.php?id=$transaksi_id");
        exit();
    }
    
    try {
        // Mulai transaksi database
        mysqli_begin_transaction($conn);
        
        // Update transaksi
        $query = "UPDATE transaksi SET 
                  transaksi_pelanggan = '$pelanggan',
                  transaksi_berat = '$berat',
                  transaksi_harga = '$transaksi_harga',
                  transaksi_tgl_selesai = '$tgl_selesai',
                  transaksi_status = '$status'
                  WHERE transaksi_id = '$transaksi_id'";
        
        if(!mysqli_query($conn, $query)) {
            throw new Exception("Gagal mengupdate transaksi: " . mysqli_error($conn));
        }
        
        // Hapus pakaian lama
        $delete_pakaian = mysqli_query($conn, "DELETE FROM pakaian WHERE pakaian_transaksi = '$transaksi_id'");
        if (!$delete_pakaian) {
            throw new Exception("Gagal menghapus data pakaian lama: " . mysqli_error($conn));
        }
        
        // Insert pakaian baru
        for($i = 0; $i < count($jenis_pakaian); $i++) {
            if(!empty(trim($jenis_pakaian[$i])) && !empty($jumlah_pakaian[$i])) {
                $jenis = mysqli_real_escape_string($conn, trim($jenis_pakaian[$i]));
                $jumlah = mysqli_real_escape_string($conn, $jumlah_pakaian[$i]);
                
                $query_pakaian = "INSERT INTO pakaian (pakaian_transaksi, pakaian_jenis, pakaian_jumlah) 
                                  VALUES ('$transaksi_id', '$jenis', '$jumlah')";
                
                if(!mysqli_query($conn, $query_pakaian)) {
                    throw new Exception("Gagal menyimpan pakaian: " . mysqli_error($conn));
                }
            }
        }
        
        // Commit transaksi
        mysqli_commit($conn);
        
        // Log aktivitas
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                      VALUES ('{$_SESSION['idadmin']}', 'Mengupdate transaksi ID: $transaksi_id')";
        mysqli_query($conn, $log_query);
        
        $_SESSION['success'] = "Transaksi berhasil diperbarui!";
        header("Location: transaksi.php?pesan=sukses_edit");
        
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($conn);
        
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: transaksi.php?pesan=gagal");
    }
} else {
    header("Location: transaksi.php");
    exit();
}
?>