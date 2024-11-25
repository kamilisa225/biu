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


#include <iostream>
using namespace std;

int main()
{
    int n = 1, sum = 0;

    while (n <= 5)
    {
        sum += n;

        for (int i = 1; i <= n; i++)
        {
            cout << i;
            if (i < n)
                cout << " + ";
        }

        int spaces = 25 - (n * 4);
        for (int i = 0; i < spaces; i++)
            cout << " ";

        cout << "= " << sum << endl;
        n++;
    }

    return 0;
}


