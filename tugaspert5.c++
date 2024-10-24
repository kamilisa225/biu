#include <iostream>
using namespace std;

int main()
{
    string namaPembeli;
    char kodeBaju;
    int jumlahBeli;
    string merkBaju;
    double hargaBaju;
    double ppn;
    double totalBayar;

    cout << "PENJUALAN BAJU ONLINE" << endl;
    cout << "Nama Pembeli: ";
    getline(cin, namaPembeli);
    cout << "Kode Baju [H / A / C]: ";
    cin >> kodeBaju;
    cout << "Jumlah beli: ";
    cin >> jumlahBeli;

    if (kodeBaju == 'H')
    {
        merkBaju = "H&R";
        hargaBaju = 85000;
    }
    else if (kodeBaju == 'A')
    {
        merkBaju = "Arrow";
        hargaBaju = 90000;
    }
    else if (kodeBaju == 'C')
    {
        merkBaju = "C59";
        hargaBaju = 150000;
    }
    else
    {
        cout << "Baju tersebut tidak terdata" << endl;
        return 1;
    }

    if (jumlahBeli > 3)
    {
        ppn = hargaBaju * 0.10;
    }
    totalBayar = (hargaBaju * jumlahBeli) + ppn;

    cout << "PENJUALAN BAJU ONLINE" << endl;
    cout << "Nama Pembeli: " << namaPembeli << endl;
    cout << "Merk Baju: " << merkBaju << endl;
    cout << "Harga Baju: " << hargaBaju << endl;
    cout << "PPN: " << ppn << endl;
    cout << "Total Bayar: " << totalBayar << endl;

    return 0;
}
