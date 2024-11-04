#include <iostream>

using namespace std;

int main()
{
    char Ksusu;
    int Ukaleng, jumlahBeli, HarperKaleng, totalBayar;

    cout << "Kode Jenis Susu:" << endl;
    cout << "A: Dancow" << endl;
    cout << "B: Bendera" << endl;
    cout << "C: SGM" << endl;
    cout << "Masukkan kode jenis susu (A/B/C): ";
    cin >> Ksusu;

    cout << "Ukuran Kaleng Susu:" << endl;
    cout << "1: Kecil" << endl;
    cout << "2: Sedang" << endl;
    cout << "3: Besar" << endl;
    cout << "Masukkan ukuran kaleng susu (1/2/3): ";
    cin >> Ukaleng;

    cout << "Masukkan jumlah pembelian: ";
    cin >> jumlahBeli;

    if (Ksusu == 'A')
    {
        if (Ukaleng == 1)
        {
            HarperKaleng = 20000;
        }
        else if (Ukaleng == 2)
        {
            HarperKaleng = 20000;
        }
        else if (Ukaleng == 3)
        {
            HarperKaleng = 15000;
        }
        else
        {
            cout << "Ukuran kaleng tidak terdata!" << endl;
            return 1;
        }
    }
    else if (Ksusu == 'B')
    {
        if (Ukaleng == 1)
        {
            HarperKaleng = 20000;
        }
        else if (Ukaleng == 2)
        {
            HarperKaleng = 17500;
        }
        else if (Ukaleng == 3)
        {
            HarperKaleng = 13500;
        }
        else
        {
            cout << "Ukuran kaleng tidak terdata!" << endl;
            return 1;
        }
    }
    else if (Ksusu == 'C')
    {
        if (Ukaleng == 1)
        {
            HarperKaleng = 22000;
        }
        else if (Ukaleng == 2)
        {
            HarperKaleng = 18500;
        }
        else if (Ukaleng == 3)
        {
            HarperKaleng = 15000;
        }
        else
        {
            cout << "Ukuran kaleng tidak terdata!" << endl;
            return 1;
        }
    }
    else
    {
        cout << "Kode jenis susu tidak terdata!" << endl;
        return 1;
    }

    totalBayar = HarperKaleng * jumlahBeli;
    cout << "Total Pembayaran: Rp " << totalBayar << endl;

    return 0;
}
