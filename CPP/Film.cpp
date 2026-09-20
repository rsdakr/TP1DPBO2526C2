#include <iostream>
#include <vector>
#include <string>

using namespace std;

class Film {
private:
  int id;
  string title;
  string genre;
  double rating;
  int release;
  int duration;

public:
  Film(int id, string title, string genre, double rating, int release, int duration) {
    this->id = id;
    this->title = title;
    this->genre = genre;
    this->rating = rating;
    this->release = release;
    this->duration = duration;
  }

  // mengembalikan id film (untuk update dan hapus data film)
  int getFilmId() const { 
    return id; 
  }

  // menampilkan detail data film
  void showFilm() const {
    cout 
    << "ID: " << id 
    << " | Judul: " << title 
    << " | Genre: " << genre 
    << " | Rating: " << rating
    << " | Rilis: " << release
    << " | Durasi: " << duration << " mnt"
    << endl;
  }

  // mengubah data film
  void updateFilm(string newTitle, string newGenre, double newRating, int newRelease, int newDuration) {
    this->title = newTitle;
    this->genre = newGenre;
    this->rating = newRating;
    this->release = newRelease;
    this->duration = newDuration;
  }
};