class Film:
  def __init__(self, id, title, genre, rating, release, duration):
    self.__id = id
    self.__title = title
    self.__genre = genre
    self.__rating = rating
    self.__release = release
    self.__duration = duration

  # mengembalikan id film (untuk update dan hapus data film)
  def getFilmId(self):
    return self.__id

  # menampilkan detail data film
  def showFilm(self):
    print(f"ID: {self.__id} | Judul: {self.__title} | Genre: {self.__genre} | Rating: {self.__rating} | Rilis: {self.__release} | Durasi: {self.__duration} mnt")

  # mengubah data film
  def updateFilm(self, newTitle, newGenre, newRating, newRelease, newDuration):
    self.__title = newTitle
    self.__genre = newGenre
    self.__rating = newRating
    self.__release = newRelease
    self.__duration = newDuration