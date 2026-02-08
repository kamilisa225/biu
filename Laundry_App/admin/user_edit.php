<?php
session_start();
include '../koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Cek apakah username sudah ada (kecuali untuk diri sendiri)
    $check = mysqli_query($conn, "SELECT * FROM admin_laundry WHERE namaadmin = '$username' AND idadmin != '$id'");
    if(mysqli_num_rows($check) > 0) {
        header("Location: user.php?pesan=username_sudah_ada");
        exit();
    }
    
    if(!empty($password)) {
        // Update dengan password baru
        $encrypted_password = md5($password);
        $query = "UPDATE admin_laundry SET namaadmin = '$username', passwordadmin = '$encrypted_password' 
                  WHERE idadmin = '$id'";
    } else {
        // Update tanpa password
        $query = "UPDATE admin_laundry SET namaadmin = '$username' WHERE idadmin = '$id'";
    }
    
    if(mysqli_query($conn, $query)) {
        // Log aktivitas
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                      VALUES ('{$_SESSION['idadmin']}', 'Mengedit admin ID: $id')";
        mysqli_query($conn, $log_query);
        
        header("Location: user.php?pesan=sukses_edit");
    } else {
        header("Location: user.php?pesan=gagal");
    }
} else {
    header("Location: user.php");
}
?>