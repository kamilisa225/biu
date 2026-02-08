<?php
echo "File transaksi_hapus.php test<br>";
echo "GET ID: " . ($_GET['id'] ?? 'tidak ada') . "<br>";
echo "Path: " . __FILE__ . "<br>";

// Tes koneksi database
require_once '../koneksi.php';
echo "Koneksi database: " . (mysqli_ping($conn) ? "OK" : "Gagal") . "<br>";

// Tes query delete
$id = $_GET['id'] ?? 5;
$query = "DELETE FROM transaksi WHERE transaksi_id = ?";
echo "Query: $query<br>";
echo "ID: $id<br>";
?>