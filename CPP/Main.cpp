#include <iostream>
#include <vector>
#include <string>
#include "Film.cpp"

using namespace std;

// mencari index film pada list/vector berdasarkan id
int cariIndexById(vector<Film> listFilm, int id) {
  for (int i = 0; i < listFilm.size(); i++) {
    if (listFilm[i].getFilmId() == id) {
      return i;
    }
  }
  return -1;
}

int main() {
  vector<Film> listFilm;
  
  // data awal / dummy
  listFilm.push_back(Film(101, "Project Hail Mary", "Sci-Fi", 8.5, 2026, 150));
  listFilm.push_back(Film(102, "Baby Driver", "Action", 7.9, 2017, 113));

  int pilihan;

  int id, release, duration;
  string title, genre;
  double rating;

  do {
    // tampilkan menu fitur
    cout << "\n=== MENU FILM BIOSKOP (versi cpp) ===\n";
    cout << "1. Tampilkan Semua Film\n";
    cout << "2. Tambah Film\n";
    cout << "3. Update Film\n";
    cout << "4. Hapus Film\n";
    cout << "5. Cari Film\n";
    cout << "6. Keluar\n";
    cout << "Pilih menu [1-6]: ";
    cin >> pilihan;

    // tampilkan semua data film
    if (pilihan == 1) {
      cout << "\n--- DAFTAR FILM ---\n";
      if (listFilm.empty()) {
        cout << "Data film masih kosong.\n";
      } else {
        for (Film film : listFilm) {
          film.showFilm();
        }
      }
    // tambahkan film baru
    } else if (pilihan == 2) {
      cout << "\n--- TAMBAH FILM ---\n";
      cout << "Masukkan ID      : ";
      cin >> id;
      if (cariIndexById(listFilm, id) != -1) {
        cout << "[!] Film dengan ID tersebut sudah ada.\n";
      } else {
        cin.ignore();
        cout << "Masukkan Judul   : ";
        getline(cin, title);
        cout << "Masukkan Genre   : ";
        getline(cin, genre);
        cout << "Masukkan Rating  : ";
        cin >> rating;
        cout << "Masukkan Rilis   : ";
        cin >> release;
        cout << "Masukkan Durasi  : ";
        cin >> duration;
        
        listFilm.push_back(Film(id, title, genre, rating, release, duration));
        cout << "[OK] Film berhasil ditambahkan.\n";
      }
    // update film yang sudah ada
    } else if (pilihan == 3) {
      cout << "\n--- UPDATE FILM ---\n";
      cout << "Masukkan ID Film yang diubah: ";
      cin >> id;
      int idx = cariIndexById(listFilm, id);
      
      if (idx == -1) {
        cout << "[!] Film tidak ditemukan.\n";
      } else {
        cin.ignore();
        cout << "Judul Baru   : ";
        getline(cin, title);
        cout << "Genre Baru   : ";
        getline(cin, genre);
        cout << "Rating Baru  : ";
        cin >> rating;
        cout << "Rilis Baru   : ";
        cin >> release;
        cout << "Durasi Baru  : ";
        cin >> duration;
        
        listFilm[idx].updateFilm(title, genre, rating, release, duration);
        cout << "[OK] Data film berhasil diperbarui.\n";
      }
    // hapus film dari list/vector
    } else if (pilihan == 4) {
      cout << "\n--- HAPUS FILM ---\n";
      cout << "Masukkan ID Film yang dihapus: ";
      cin >> id;
      int idx = cariIndexById(listFilm, id);
      
      if (idx == -1) {
        cout << "[!] Film tidak ditemukan.\n";
      } else {
        listFilm.erase(listFilm.begin() + idx);
        cout << "[OK] Film berhasil dihapus.\n";
      }
    // cari dan tampilkan film berdasarkan id
    } else if (pilihan == 5) {
      cout << "\n--- CARI FILM ---\n";
      cout << "Masukkan ID Film yang dicari: ";
      cin >> id;
      int idx = cariIndexById(listFilm, id);
      
      if (idx == -1) {
        cout << "[!] Film tidak ditemukan.\n";
      } else {
        cout << "Data ditemukan:\n";
        listFilm[idx].showFilm();
      }
    }
  } while (pilihan != 6);

  cout << "Terima Kasih.\n";
  return 0;
}