<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'] ?? 0;

// Cek apakah mencoba menghapus akun sendiri
if($id == $_SESSION['idadmin']) {
    header("Location: user.php?pesan=akses_terlarang");
    exit();
}

// Hapus admin
$query = "DELETE FROM admin_laundry WHERE idadmin = '$id'";
if(mysqli_query($conn, $query)) {
    // Log aktivitas
    $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                  VALUES ('{$_SESSION['idadmin']}', 'Menghapus admin ID: $id')";
    mysqli_query($conn, $log_query);
    
    header("Location: user.php?pesan=sukses_hapus");
} else {
    header("Location: user.php?pesan=gagal");
}
?>