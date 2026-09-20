public class Film {
  private int id;
  private String title;
  private String genre;
  private double rating;
  private int release;
  private int duration;

  public Film(int id, String title, String genre, double rating, int release, int duration) {
    this.id = id;
    this.title = title;
    this.genre = genre;
    this.rating = rating;
    this.release = release;
    this.duration = duration;
  }

  // mengembalikan id film (untuk update dan hapus data film)
  public int getFilmId() {
    return id;
  }

  // menampilkan detail data film
  public void showFilm() {
    System.out.println("ID: " + id + " | Judul: " + title + " | Genre: " + genre + " | Rating: " + rating + " | Rilis: " + release + " | Durasi: " + duration + " mnt");
  }

  // mengubah data film
  public void updateFilm(String newTitle, String newGenre, double newRating, int newRelease, int newDuration) {
    this.title = newTitle;
    this.genre = newGenre;
    this.rating = newRating;
    this.release = newRelease;
    this.duration = newDuration;
  }
}