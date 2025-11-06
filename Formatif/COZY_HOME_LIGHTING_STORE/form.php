<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Home Lighting Store</title>
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
    <h2>Cozy Home Lighting Store</h2>
    <h4>Toko Lampu Dekorasi Rumah</h4>
    <p style="text-align:center;"><i>Jl. Ujung Situ Bekasi</i></p>
    <hr>

    <form action="strukpembelian.php" method="POST">
        <table>
            <tr>
                <td width="150">Nama Pembeli</td>
                <td><input type="text" name="nama" required></td>
            </tr>
            <tr>
                <td>Pembelian Barang</td>
                <td>
                    <select name="judul" required>
                        <option value="">-- Pilih --</option>
                        <option value="Lampu Senja">Lampu Senja</option>
                        <option value="Lampu Tembok">Lampu Tembok</option>
                        <option value="Lampu Gantung">Lampu Gantung</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Warna</td>
                <td>
                    <input type="radio" name="warna" value="Warm White" required>Warm White
                    <input type="radio" name="warna" value="Cool White" required> Cool White
                </td>
            </tr>
            <tr>
                <td>Jumlah Beli</td>
                <td><input type="number" name="jumlah" min="0" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-submit">SUBMIT</button>
                    <button type="reset" class="btn btn-reset">BATAL</button>
                </td>
            </tr>
        </table>
    </form>

    <div class="footer">
        - - - Kasir Cozy Home Lighting Store - - -
    </div>
</div>
</body>
</html>

