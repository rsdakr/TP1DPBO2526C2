<?php
// class film dengan encapsulation
class Film {
  private $id;
  private $title;
  private $genre;
  private $rating;
  private $release;
  private $duration;
  private $image;

  public function __construct($id, $title, $genre, $rating, $release, $duration, $image) {
    $this->id = $id;
    $this->title = $title;
    $this->genre = $genre;
    $this->rating = $rating;
    $this->release = $release;
    $this->duration = $duration;
    $this->image = $image;
  }

  // mengembalikan id film (untuk update dan hapus data film)
  public function getFilmId() {
    return $this->id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getGenre() {
    return $this->genre;
  }

  public function getRating() {
    return $this->rating;
  }

  public function getRelease() {
    return $this->release;
  }

  public function getDuration() {
    return $this->duration;
  }

  public function getImage() {
    return $this->image;
  }

  // mengubah data film
  public function updateFilm($newTitle, $newGenre, $newRating, $newRelease, $newDuration, $newImage) {
    $this->title = $newTitle;
    $this->genre = $newGenre;
    $this->rating = $newRating;
    $this->release = $newRelease;
    $this->duration = $newDuration;
    if ($newImage != "") {
      $this->image = $newImage;
    }
  }
}
?>