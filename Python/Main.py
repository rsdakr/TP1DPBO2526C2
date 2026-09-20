from Film import Film

# mencari index film pada list/vector berdasarkan id
def cariIndexById(listFilm, id):
  for i in range(len(listFilm)):
    if listFilm[i].getFilmId() == id:
      return i
  return -1


def main():
  listFilm = []

  # data awal / dummy
  listFilm.append(Film(101, "Project Hail Mary", "Sci-Fi", 8.5, 2026, 150))
  listFilm.append(Film(102, "Baby Driver", "Action", 7.9, 2017, 113))

  pilihan = 0

  while pilihan != 6:
    # tampilkan menu fitur
    print("\n=== MENU FILM BIOSKOP (versi python) ===")
    print("1. Tampilkan Semua Film")
    print("2. Tambah Film")
    print("3. Update Film")
    print("4. Hapus Film")
    print("5. Cari Film")
    print("6. Keluar")
    pilihan = int(input("Pilih menu [1-6]: "))

    # tampilkan semua data film
    if pilihan == 1:
      print("\n--- DAFTAR FILM ---")
      if not listFilm:
        print("Data film masih kosong.")
      else:
        for film in listFilm:
          film.showFilm()

    # tambahkan film baru
    elif pilihan == 2:
      print("\n--- TAMBAH FILM ---")
      id = int(input("Masukkan ID      : "))
      if cariIndexById(listFilm, id) != -1:
        print("[!] Film dengan ID tersebut sudah ada.")
      else:
        title = input("Masukkan Judul   : ")
        genre = input("Masukkan Genre   : ")
        rating = float(input("Masukkan Rating  : "))
        release = int(input("Masukkan Rilis   : "))
        duration = int(input("Masukkan Durasi  : "))

        listFilm.append(Film(id, title, genre, rating, release, duration))
        print("[OK] Film berhasil ditambahkan.")

    # update film yang sudah ada
    elif pilihan == 3:
      print("\n--- UPDATE FILM ---")
      id = int(input("Masukkan ID Film yang diubah: "))
      idx = cariIndexById(listFilm, id)

      if idx == -1:
        print("[!] Film tidak ditemukan.")
      else:
        title = input("Judul Baru   : ")
        genre = input("Genre Baru   : ")
        rating = float(input("Rating Baru  : "))
        release = int(input("Rilis Baru   : "))
        duration = int(input("Durasi Baru  : "))

        listFilm[idx].updateFilm(title, genre, rating, release, duration)
        print("[OK] Data film berhasil diperbarui.")

    # hapus film dari list/vector
    elif pilihan == 4:
      print("\n--- HAPUS FILM ---")
      id = int(input("Masukkan ID Film yang dihapus: "))
      idx = cariIndexById(listFilm, id)

      if idx == -1:
        print("[!] Film tidak ditemukan.")
      else:
        listFilm.pop(idx)
        print("[OK] Film berhasil dihapus.")

    # cari dan tampilkan film berdasarkan id
    elif pilihan == 5:
      print("\n--- CARI FILM ---")
      id = int(input("Masukkan ID Film yang dicari: "))
      idx = cariIndexById(listFilm, id)

      if idx == -1:
        print("[!] Film tidak ditemukan.")
      else:
        print("Data ditemukan:")
        listFilm[idx].showFilm()

  print("Terima Kasih.")


if __name__ == "__main__":
  main()