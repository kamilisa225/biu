<?php
// koneksi.php - Koneksi Database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_laundry';

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error reporting (nonaktifkan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>