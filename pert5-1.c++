#include <iostream>

using namespace std;

int main()
{
    char kode;
    int jumlah;
    string merk;
    int harga;
    int ppn;
    int totalBayar;

    cout << "PENJUALAN SEPATU ONLINE" << endl;
    cout << "Kode sepatu [A/R/N] : ";
    cin >> kode;
    cout << "Jumlah sepatu : ";
    cin >> jumlah;

    if (kode == 'A' || kode == 'A')
    {
        merk = "Adidas";
        harga = 850000;
    }
    else if (kode == 'R' || kode == 'R')
    {
        merk = "Reebok";
        harga = 900000;
    }
    else if (kode == 'N' || kode == 'N')
    {
        merk = "Nike";
        harga = 1500000;
    }
    else
    {
        cout << "sepatu tersebut tidak terdata!" << endl;
        return 1;
    }

    if (jumlah > 3)
    {
        ppn = 0.10 * (harga * jumlah);
    }
    else
    {
        ppn = 0;
    }

    totalBayar = (harga * jumlah) + ppn;

    cout << "Merk sepatu : " << merk << endl;
    cout << "Harga satuan : Rp" << harga << endl;
    cout << "PPN : Rp" << ppn << endl;
    cout << "Total bayar : Rp" << totalBayar << endl;

    return 0;
}
