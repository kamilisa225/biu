<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash password dengan MD5 (untuk demo, gunakan password_hash() di production)
    $hashed_password = md5($password);
    
    // Query untuk mencari admin
    $query = "SELECT * FROM admin_laundry WHERE namaadmin = ? AND passwordadmin = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Set session
        $_SESSION['idadmin'] = $admin['idadmin'];
        $_SESSION['username'] = $admin['namaadmin'];
        $_SESSION['status'] = "login";
        $_SESSION['login_time'] = time();
        
        // Log aktivitas login
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) VALUES (?, 'Login ke sistem')";
        $log_stmt = mysqli_prepare($conn, $log_query);
        mysqli_stmt_bind_param($log_stmt, "i", $_SESSION['idadmin']);
        mysqli_stmt_execute($log_stmt);
        
        // Redirect ke dashboard
        header("Location: admin/index.php");
        exit();
    } else {
        header("Location: index.php?pesan=gagal");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>