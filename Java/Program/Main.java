import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class Main {
  // mencari index film pada list/vector berdasarkan id
  public static int cariIndexById(List<Film> listFilm, int id) {
    for (int i = 0; i < listFilm.size(); i++) {
      if (listFilm.get(i).getFilmId() == id) {
        return i;
      }
    }
    return -1;
  }

  public static void main(String[] args) {
    Scanner scanner = new Scanner(System.in);
    List<Film> listFilm = new ArrayList<>();

    // data awal / dummy
    listFilm.add(new Film(101, "Project Hail Mary", "Sci-Fi", 8.5, 2026, 150));
    listFilm.add(new Film(102, "Baby Driver", "Action", 7.9, 2017, 113));

    int pilihan;

    int id, release, duration;
    String title, genre;
    double rating;

    do {
      // tampilkan menu fitur
      System.out.println("\n=== MENU FILM BIOSKOP (versi java) ===");
      System.out.println("1. Tampilkan Semua Film");
      System.out.println("2. Tambah Film");
      System.out.println("3. Update Film");
      System.out.println("4. Hapus Film");
      System.out.println("5. Cari Film");
      System.out.println("6. Keluar");
      System.out.print("Pilih menu [1-6]: ");
      pilihan = scanner.nextInt();

      // tampilkan semua data film
      if (pilihan == 1) {
        System.out.println("\n--- DAFTAR FILM ---");
        if (listFilm.isEmpty()) {
          System.out.println("Data film masih kosong.");
        } else {
          for (Film film : listFilm) {
            film.showFilm();
          }
        }
      // tambahkan film baru
      } else if (pilihan == 2) {
        System.out.println("\n--- TAMBAH FILM ---");
        System.out.print("Masukkan ID      : ");
        id = scanner.nextInt();
        if (cariIndexById(listFilm, id) != -1) {
          System.out.println("[!] Film dengan ID tersebut sudah ada.");
        } else {
          scanner.nextLine();
          System.out.print("Masukkan Judul   : ");
          title = scanner.nextLine();
          System.out.print("Masukkan Genre   : ");
          genre = scanner.nextLine();
          System.out.print("Masukkan Rating  : ");
          rating = scanner.nextDouble();
          System.out.print("Masukkan Rilis   : ");
          release = scanner.nextInt();
          System.out.print("Masukkan Durasi  : ");
          duration = scanner.nextInt();

          listFilm.add(new Film(id, title, genre, rating, release, duration));
          System.out.println("[OK] Film berhasil ditambahkan.");
        }
      // update film yang sudah ada
      } else if (pilihan == 3) {
        System.out.println("\n--- UPDATE FILM ---");
        System.out.print("Masukkan ID Film yang diubah: ");
        id = scanner.nextInt();
        int idx = cariIndexById(listFilm, id);

        if (idx == -1) {
          System.out.println("[!] Film tidak ditemukan.");
        } else {
          scanner.nextLine();
          System.out.print("Judul Baru   : ");
          title = scanner.nextLine();
          System.out.print("Genre Baru   : ");
          genre = scanner.nextLine();
          System.out.print("Rating Baru  : ");
          rating = scanner.nextDouble();
          System.out.print("Rilis Baru   : ");
          release = scanner.nextInt();
          System.out.print("Durasi Baru  : ");
          duration = scanner.nextInt();

          listFilm.get(idx).updateFilm(title, genre, rating, release, duration);
          System.out.println("[OK] Data film berhasil diperbarui.");
        }
      // hapus film dari list/vector
      } else if (pilihan == 4) {
        System.out.println("\n--- HAPUS FILM ---");
        System.out.print("Masukkan ID Film yang dihapus: ");
        id = scanner.nextInt();
        int idx = cariIndexById(listFilm, id);

        if (idx == -1) {
          System.out.println("[!] Film tidak ditemukan.");
        } else {
          listFilm.remove(idx);
          System.out.println("[OK] Film berhasil dihapus.");
        }
      // cari dan tampilkan film berdasarkan id
      } else if (pilihan == 5) {
        System.out.println("\n--- CARI FILM ---");
        System.out.print("Masukkan ID Film yang dicari: ");
        id = scanner.nextInt();
        int idx = cariIndexById(listFilm, id);

        if (idx == -1) {
          System.out.println("[!] Film tidak ditemukan.");
        } else {
          System.out.println("Data ditemukan:");
          listFilm.get(idx).showFilm();
        }
      }
    } while (pilihan != 6);

    System.out.println("Terima Kasih.");
    scanner.close();
  }
}