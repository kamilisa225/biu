<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'] ?? 0;

// Hapus pelanggan
$query = "DELETE FROM pelanggan WHERE idpelanggan = '$id'";
if(mysqli_query($conn, $query)) {
    // Log aktivitas
    $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                  VALUES ('{$_SESSION['idadmin']}', 'Menghapus pelanggan ID: $id')";
    mysqli_query($conn, $log_query);
    
    header("Location: pelanggan.php?pesan=sukses_hapus");
} else {
    header("Location: pelanggan.php?pesan=gagal");
}
?>