<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }
        .container {
            width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 25px 40px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
            border-radius: 8px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        hr {
            border: 1px solid rgba(0, 221, 151, 1);
            margin: 10px 0 20px;
        }
        table {
            width: 100%;
        }
        td {
            padding: 5px;
        }
        input[type=text],
        input[type=number],
        input[type=date],
        select {
            width: 95%;
            padding: 5px;
            font-size: 14px;
        }
        .btn {
            padding: 6px 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-submit { background: #4caf50; color: white; }
        .btn-reset { background: #e53935; color: white; }
        .footer {
            text-align: center;
            font-style: italic;
            color: gray;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>COZY HOME LIGHTING STORE</h2>
    <h4>Hasil Pembelian</h4>
    <hr>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama   = $_POST['nama'];
        $barang = $_POST['judul'];
        $warna  = $_POST['warna'];
        $jumlah = $_POST['jumlah'];

        if ($barang == "Lampu Senja") {
            $harga = 45000;
            $kode  = "LS001";
        } elseif ($barang == "Lampu Tembok") {
            $harga = 75000;
            $kode  = "LT002";
        } elseif ($barang == "Lampu Gantung") {
            $harga = 120000;
            $kode  = "LG003";
        } else {
            $harga = 0;
            $kode  = "-";
        }

        $total = $jumlah * $harga;

        if ($total > 200000) {
            $ppn = $total * 0.11;
            $bonus = "Dekorasi Gantung Mini";
        } else {
            $ppn = 0;
            $bonus = "Tidak ada bonus";
        }

        if ($total >= 500000) {
            $diskon = $total * 0.10;
        } elseif ($total >= 300000) {
            $diskon = $total * 0.05;
        } else {
            $diskon = 0;
        }

        $totalAkhir = $total + $ppn - $diskon;
    ?>

    <table>
        <tr><td><b>Kode Barang</b></td><td>: <?= $kode ?></td></tr>
        <tr><td><b>Nama Pembeli</b></td><td>: <?= htmlspecialchars($nama) ?></td></tr>
        <tr><td><b>Nama Barang</b></td><td>: <?= $barang ?></td></tr>
        <tr><td><b>Warna</b></td><td>: <?= $warna ?></td></tr>
        <tr><td><b>Harga Satuan</b></td><td>: Rp <?= number_format($harga,0,',','.') ?></td></tr>
        <tr><td><b>Jumlah Beli</b></td><td>: <?= $jumlah ?></td></tr>
        <tr><td><b>Total</b></td><td>: Rp <?= number_format($total,0,',','.') ?></td></tr>
        <tr><td><b>PPN 11%</b></td><td>: Rp <?= number_format($ppn,0,',','.') ?></td></tr>
        <tr><td><b>Diskon</b></td><td>: Rp <?= number_format($diskon,0,',','.') ?></td></tr>
        <tr><td><b>Total Akhir</b></td><td><b>: Rp <?= number_format($totalAkhir,0,',','.') ?></b></td></tr>
        <tr><td><b>Bonus</b></td><td>: <?= $bonus ?></td></tr>
    </table>

    <br>
    <div style="text-align:center;">
        <a href="form.php" class="btn-back">Kembali ke Form</a>
    </div>

    <?php
    } else {
        echo "<p style='text-align:center;'>Tidak ada data yang dikirim.</p>";
    }
    ?>
    
    <div class="footer">
        - - - Struk Pembelian Cozy Home Lighting Store - - -
    </div>
</div>

</body>
</html>
