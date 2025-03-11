import java.util.Scanner;

class MathOperations {
    public int calculate(int a, int b) {
        return a + b;
    }

    public double calculate(double a, double b) {
        return a * b;
    }

    public double calculate(int a, int b, int c) {
        return (a + b + c) / 3.0;
    }
}

public class TestMathOperations {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        MathOperations mathOps = new MathOperations();

        System.out.print("Masukkan bilangan pertama (int): ");
        int num1 = scanner.nextInt();
        System.out.print("Masukkan bilangan kedua (int): ");
        int num2 = scanner.nextInt();
        System.out.println("Hasil Penjumlahan: " + mathOps.calculate(num1, num2));

        System.out.print("Masukkan bilangan pertama (double): ");
        double num3 = scanner.nextDouble();
        System.out.print("Masukkan bilangan kedua (double): ");
        double num4 = scanner.nextDouble();
        System.out.println("Hasil Perkalian: " + mathOps.calculate(num3, num4));

        System.out.print("Masukkan bilangan pertama (int): ");
        int num5 = scanner.nextInt();
        System.out.print("Masukkan bilangan kedua (int): ");
        int num6 = scanner.nextInt();
        System.out.print("Masukkan bilangan ketiga (int): ");
        int num7 = scanner.nextInt();
        System.out.println("Hasil Rata-rata: " + mathOps.calculate(num5, num6, num7));

        scanner.close();
    }
}
