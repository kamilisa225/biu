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
    if(empty($_POST['pelanggan']) || empty($_POST['berat']) || empty($_POST['tgl_selesai'])) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location: transaksi_tambah.php");
        exit();
    }
    
    $pelanggan = mysqli_real_escape_string($conn, $_POST['pelanggan']);
    $berat = mysqli_real_escape_string($conn, $_POST['berat']);
    $tgl_selesai = mysqli_real_escape_string($conn, $_POST['tgl_selesai']);
    $transaksi_harga = mysqli_real_escape_string($conn, $_POST['transaksi_harga']);
    $jenis_pakaian = $_POST['jenis_pakaian'] ?? [];
    $jumlah_pakaian = $_POST['jumlah_pakaian'] ?? [];
    
    // Validasi data
    if($berat <= 0) {
        $_SESSION['error'] = "Berat harus lebih dari 0 kg!";
        header("Location: transaksi_tambah.php");
        exit();
    }
    
    if(empty($jenis_pakaian)) {
        $_SESSION['error'] = "Minimal isi 1 jenis pakaian!";
        header("Location: transaksi_tambah.php");
        exit();
    }
    
    try {
        // Mulai transaksi database
        mysqli_begin_transaction($conn);
        
        // Insert transaksi
        $query = "INSERT INTO transaksi (transaksi_tgl, transaksi_pelanggan, transaksi_harga, 
                  transaksi_berat, transaksi_tgl_selesai, transaksi_status) 
                  VALUES (CURDATE(), '$pelanggan', '$transaksi_harga', '$berat', '$tgl_selesai', '0')";
        
        if(!mysqli_query($conn, $query)) {
            throw new Exception("Gagal menyimpan transaksi: " . mysqli_error($conn));
        }
        
        $transaksi_id = mysqli_insert_id($conn);
        
        // Insert pakaian
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
                      VALUES ('{$_SESSION['idadmin']}', 'Menambah transaksi baru ID: $transaksi_id')";
        mysqli_query($conn, $log_query);
        
        $_SESSION['success'] = "Transaksi berhasil ditambahkan!";
        header("Location: transaksi.php?pesan=sukses_tambah");
        
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