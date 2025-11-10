<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgmvk3U1F4MkaxBg6GW2Xshn6AgUUkQclFJQ&s");
        }
        .container {
            width: 600px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 25px 40px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
            border-radius: 8px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        hr {
            border: 1px solid rgba(144, 247, 41, 1);
            margin: 10px 0 20px;
        }
        table {
            width: 100%;
        }
        td {
            padding: 5px;
        }
        .btn {
            display: inline-block;
            padding: 6px 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            background: #4caf50;
            color: white;
            text-decoration: none;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            font-style: italic;
            color: gray;
            margin-top: 15px;
        }
        .logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 10px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Camping Gear Store</h2>
    <h4>Struk Pembelian</h4>
    <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fidn.freepik.com%2Fvektor-premium%2Fpendaki-gunung-dan-langit-untuk-inspirasi-desain-logo-toko-perjalanan-petualang-hipster_19026612.htm&psig=AOvVaw0dEt2Z8lTjr_Mw7lbLCvYZ&ust=1762830180972000&source=images&cd=vfe&opi=89978449&ved=2ahUKEwjDsZSnzOaQAxWJaioJHTdYDTgQjRx6BAgAEBo" class="logo">
    <hr>

    <?php
    function rupiah($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }

    function hitungPembayaran($kode, $jumlah) {
        $harga = 0;
        switch ($kode) {
            case "K001": $harga = 350000; break;
            case "K002": $harga = 550000; break;
            case "K003": $harga = 250000; break;
            case "K004": $harga = 300000; break;
            case "K005": $harga = 800000; break;
            case "K006": $harga = 150000; break;
        }
        return $harga * $jumlah;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'];
        $tanggal = $_POST['tanggal_beli'];
        $kode = $_POST['kode'];
        $ukuran = $_POST['warna'];
        $jumlah = $_POST['jumlah'];

        if ($jumlah == "" || !is_numeric($jumlah) || $jumlah <= 0) {
            echo "<p style='color:red; text-align:center;'>Jumlah beli harus diisi dengan angka yang benar!</p>";
            echo "<div style='text-align:center;'><a href='index.html' class='btn'>Kembali</a></div>";
            exit;
        }

        $total = hitungPembayaran($kode, $jumlah);
        $bonus = ($total >= 1000000) ? "Headlamp" : "Tidak ada bonus";
        $diskon = 0;
        if ($jumlah >= 3) {
            $diskon = $total * 0.10;
        }
        $totalAkhir = $total - $diskon;

        echo "<table>";
        echo "<tr><td>Nama Pembeli</td><td>: $nama</td></tr>";
        echo "<tr><td>Tanggal Pembelian</td><td>: $tanggal</td></tr>";
        echo "<tr><td>Kode Barang</td><td>: $kode</td></tr>";
        echo "<tr><td>Ukuran</td><td>: $ukuran</td></tr>";
        echo "<tr><td>Jumlah Beli</td><td>: $jumlah</td></tr>";
        echo "<tr><td>Total Bayar</td><td>: ".rupiah($total)."</td></tr>";
        echo "<tr><td>Diskon</td><td>: ".rupiah($diskon)."</td></tr>";
        echo "<tr><td>Total Akhir</td><td>: ".rupiah($totalAkhir)."</td></tr>";
        echo "<tr><td>Bonus</td><td>: $bonus</td></tr>";
        echo "</table>";
        echo "<div style='text-align:center;'><a href='GearStore.php' class='btn'>Input Kembali</a></div>";
    }
    ?>

    <div class="footer">
        - - - Terima Kasih Telah Berbelanja di Camping Gear Store - - -
    </div>
</div>

</body>
</html>
