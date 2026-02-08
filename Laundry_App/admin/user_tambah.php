<?php
session_start();
include '../koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Cek apakah username sudah ada
    $check = mysqli_query($conn, "SELECT * FROM admin_laundry WHERE namaadmin = '$username'");
    if(mysqli_num_rows($check) > 0) {
        header("Location: user.php?pesan=username_sudah_ada");
        exit();
    }
    
    // Enkripsi password dengan MD5
    $encrypted_password = md5($password);
    
    // Tambah admin baru
    $query = "INSERT INTO admin_laundry (namaadmin, passwordadmin, created_at) 
              VALUES ('$username', '$encrypted_password', NOW())";
    
    if(mysqli_query($conn, $query)) {
        // Log aktivitas
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                      VALUES ('{$_SESSION['idadmin']}', 'Menambah admin baru: $username')";
        mysqli_query($conn, $log_query);
        
        header("Location: user.php?pesan=sukses_tambah");
    } else {
        header("Location: user.php?pesan=gagal");
    }
} else {
    header("Location: user.php");
}
?>