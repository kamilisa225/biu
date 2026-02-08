<?php
session_start();
include '../koneksi.php';

if(isset($_SESSION['idadmin'])) {
    // Log aktivitas logout
    $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                  VALUES ('{$_SESSION['idadmin']}', 'Logout dari sistem')";
    @mysqli_query($conn, $log_query);
}

session_destroy();
header("Location: ../index.php?pesan=logout");
exit();
?>