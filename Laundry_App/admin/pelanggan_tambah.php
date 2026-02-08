<?php
session_start();
include '../koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    
    $query = "INSERT INTO pelanggan (namapelanggan, alamat, hppelanggan, created_at) 
              VALUES ('$nama', '$alamat', '$telepon', NOW())";
    
    if(mysqli_query($conn, $query)) {
        // Log aktivitas
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                      VALUES ('{$_SESSION['idadmin']}', 'Menambah pelanggan: $nama')";
        mysqli_query($conn, $log_query);
        
        header("Location: pelanggan.php?pesan=sukses_tambah");
    } else {
        header("Location: pelanggan.php?pesan=gagal");
    }
} else {
    header("Location: pelanggan.php");
}
?>