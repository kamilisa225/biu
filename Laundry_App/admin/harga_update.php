<?php
session_start();
include '../koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $harga_baru = mysqli_real_escape_string($conn, $_POST['harga_per_kilo']);
    
    // Ambil harga lama
    $query_lama = "SELECT harga_per_kilo FROM harga LIMIT 1";
    $result_lama = mysqli_query($conn, $query_lama);
    $harga_lama = mysqli_fetch_assoc($result_lama);
    
    // Update harga
    $query = "UPDATE harga SET harga_per_kilo = '$harga_baru', updated_at = NOW()";
    
    if(mysqli_query($conn, $query)) {
        // Simpan riwayat perubahan (jika tabel riwayat_harga ada)
        $query_riwayat = "INSERT INTO riwayat_harga (harga_lama, harga_baru, dibuat_oleh) 
                          VALUES ('{$harga_lama['harga_per_kilo']}', '$harga_baru', '{$_SESSION['idadmin']}')";
        @mysqli_query($conn, $query_riwayat); // @ untuk suppress error jika tabel tidak ada
        
        // Log aktivitas
        $log_query = "INSERT INTO log_aktivitas (id_admin, aktivitas) 
                      VALUES ('{$_SESSION['idadmin']}', 'Mengubah harga dari Rp {$harga_lama['harga_per_kilo']} menjadi Rp $harga_baru per kg')";
        mysqli_query($conn, $log_query);
        
        header("Location: harga.php?pesan=sukses");
    } else {
        header("Location: harga.php?pesan=gagal");
    }
} else {
    header("Location: harga.php");
}
?>