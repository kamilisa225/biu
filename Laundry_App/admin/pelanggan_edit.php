<?php
session_start();
include '../koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    
    $query = "UPDATE pelanggan SET 
              namapelanggan = '$nama', 
              alamat = '$alamat', 
              hppelanggan = '$telepon' 
              WHERE idpelanggan = '$id'";
    
    if(mysqli_query($conn, $query)) {
        // Log aktivitas
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                      VALUES ('{$_SESSION['idadmin']}', 'Mengedit pelanggan ID: $id')";
        mysqli_query($conn, $log_query);
        
        header("Location: pelanggan.php?pesan=sukses_edit");
    } else {
        header("Location: pelanggan.php?pesan=gagal");
    }
} else {
    header("Location: pelanggan.php");
}
?>