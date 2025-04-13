import java.util.Scanner;

public class QuizApp {
    public static void main(String[] args) throws InterruptedException {
        Scanner input = new Scanner(System.in);

        System.out.println("\n=== Selamat datang di Kuis Pengetahuan Umum! ===");

        // Input Nama dan Kelas
        System.out.print("Masukkan Nama kamu: ");
        String nama = input.nextLine();
        System.out.print("Masukkan Kelas kamu: ");
        String kelas = input.nextLine();

        String[] soal = {
                "1. Apa Ibukota Jawa Tengah?\nA. Tegal\nB. Ambon\nC. Samarinda\nD. Semarang",
                "2. Warna kampus bina insani ialah?\nA. Merah\nB. Hijau\nC. Biru\nD. Kuning",
                "3. Siapa mahasiswa TI24A yang sering terlambat?\nA. Emill\nB. Jose\nC. Umam\nD. Arjuna",
                "4. Siapa nama asli Kiting?\nA. Mamat\nB. Rizky\nC. Daffa\nD. Majid",
                "5. Berapa jumlah benua di dunia?\nA. 6\nB. 5\nC. 8\nD. 7",
                "6. Depan kampus Bina Insani ada?\nA. Halte\nB. Fly Over\nC. Foto Copy\nD. Pos Satpam",
                "7. Berapa harga pakrir motor Univ Bina Insani?\nA. 2k\nB. 4k\nC. 3k\nD. 5k",
                "8. Rizky Surya biasa dipanggil?\nA. Copet\nB. Tompel\nC. Abut\nD. Pendo",
                "9. Output dari gerbang logika OR adalah 1 jika?\nA. Semua input 0\nB. Input berbeda\nC. Semua input 1\nD. Salah satu input 1",
                "10. Siapa nama dosen Algoritma dan Pemrograman II TI24?\nA. Pak Jajang\nB. Bu Rita\nC. Pak Solikin\nD. Pak Imam"
        };

        char[] jawabanBenar = { 'C', 'C', 'B', 'D', 'B', 'B', 'A', 'C', 'D', 'D' };
        char[] jawabanUser = new char[10];
        int skor = 0;

        for (int i = 0; i < soal.length; i++) {
            System.out.println("\n" + soal[i]);
            System.out.print("Jawaban kamu (A/B/C/D): ");
            char jawaban = Character.toUpperCase(input.next().charAt(0));

            if (jawaban != 'A' && jawaban != 'B' && jawaban != 'C' && jawaban != 'D') {
                System.out.println("[!] Jawaban tidak valid, soal dilewati.");
                jawabanUser[i] = '-';
            } else {
                jawabanUser[i] = jawaban;
                if (jawaban == jawabanBenar[i]) {
                    System.out.println("[✓] Jawaban kamu benar!");
                    skor += 10;
                } else {
                    System.out.println("[X] Jawaban belum tepat. Tetap semangat!");
                }
            }

            Thread.sleep(1000);
        }

        // Menentukan Grade
        char grade;
        if (skor == 100)
            grade = 'A';
        else if (skor >= 80)
            grade = 'B';
        else if (skor >= 60)
            grade = 'C';
        else if (skor >= 40)
            grade = 'D';
        else
            grade = 'E';

        // Tanya apakah ingin lihat hasil
        System.out.print("\nIngin lihat hasil kamu? (Y/N): ");
        char lihatHasil = Character.toUpperCase(input.next().charAt(0));

        if (lihatHasil == 'Y') {
            System.out.println("\n===== HASIL KUIS =====");
            System.out.println("Nama  : " + nama);
            System.out.println("Kelas : " + kelas);
            System.out.println("Skor  : " + skor + " / 100");
            System.out.println("Grade : " + grade);
            System.out.println("\nJawaban kamu:");

            for (int i = 0; i < soal.length; i++) {
                if (jawabanUser[i] == '-') {
                    System.out.println("Soal " + (i + 1) + ": [!] Tidak dijawab");
                } else if (jawabanUser[i] == jawabanBenar[i]) {
                    System.out.println("Soal " + (i + 1) + ": [✓] Benar");
                } else {
                    System.out.println("Soal " + (i + 1) + ": [X] Salah");
                }
            }
        } else {
            System.out.println("Oke! Sampai jumpa di kuis berikutnya!");
        }
    }
}
