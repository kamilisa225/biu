<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgmvk3U1F4MkaxBg6GW2Xshn6AgUUkQclFJQ&s");
        }
        .container {
            width: 600px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.65);
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
        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 10px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fidn.freepik.com%2Fvektor-premium%2Fpendaki-gunung-dan-langit-untuk-inspirasi-desain-logo-toko-perjalanan-petualang-hipster_19026612.htm&psig=AOvVaw0dEt2Z8lTjr_Mw7lbLCvYZ&ust=1762830180972000&source=images&cd=vfe&opi=89978449&ved=2ahUKEwjDsZSnzOaQAxWJaioJHTdYDTgQjRx6BAgAEBo" class="logo">
    <h2>Camping Gear Store</h2>
    <h4>Menyediakan peralatan mendaki gunung</h4>
    <p style="text-align:center;"><i>Jl. Pojok Sonoan Bekasi</i></p>
    <hr>

    <form action="StrukGS.php" method="POST">
        <table>
            <tr>
                <td width="150">Nama Pembeli</td>
                <td><input type="text" name="nama" required></td>
            </tr>
            <tr>
                <td>Tanggal Pembelian</td>
                <td><input type="date" name="tanggal_beli" required></td>
            </tr>
            <tr>
                <td>Kode Barang</td>
                <td>
                    <select name="kode" required>
                        <option value="">-- Pilih --</option>
                        <option value="K001">K001 | Tas Carrier Regular </option>
                        <option value="K002">K002 | Tas Carrier Premium </option>
                        <option value="K003">K003 | Sleeping Bag        </option>
                        <option value="K004">K004 | Sepaket Alat Masak  </option>
                        <option value="K005">K005 | Tenda Camping         </option>
                        <option value="K006">K006 | Sepaket P3K         </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ukuran</td>
                <td>
                    <input type="radio" name="warna" value="S" required>S
                    <input type="radio" name="warna" value="M" required>M
                    <input type="radio" name="warna" value="L" required>L
                </td>
            </tr>
            <tr>
                <td>Jumlah Beli</td>
                <td><input type="number" name="jumlah" min="0" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-submit">SIMPAN</button>
                    <button type="reset" class="btn btn-reset">BATAL</button>
                </td>
            </tr>
        </table>
    </form>

    <div class="footer">
        - - - Kasir Camping Gear Store - - -
    </div>
</div>
</body>
</html>
