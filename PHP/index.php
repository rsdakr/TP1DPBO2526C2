<?php
require_once __DIR__ . '/Film.php';
session_start();

// mencari index film pada list berdasarkan id
function cariIndexById($listFilm, $id) {
  for ($i = 0; $i < count($listFilm); $i++) {
    if ($listFilm[$i]->getFilmId() == $id) {
      return $i;
    }
  }
  return -1;
}

// inisialisasi session dan data awal / dummy
if (!isset($_SESSION['listFilm'])) {
  $_SESSION['listFilm'] = [
    new Film(101, "Project Hail Mary", "Sci-Fi", 8.5, 2026, 150, "uploads/projecthailmary.jpg"),
    new Film(102, "Baby Driver", "Action", 7.9, 2017, 113, "uploads/babydriver.jpg")
  ];
}

$editFilm = null;
$searchResult = null;
$message = "";

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

// penanganan form post (tambah / update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $action = $_POST['action'] ?? '';

  // tambahkan film baru
  if ($action == 'tambah') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $rating = floatval($_POST['rating']);
    $release = intval($_POST['release']);
    $duration = intval($_POST['duration']);
    $imagePath = "uploads/default.jpg";

    if (cariIndexById($_SESSION['listFilm'], $id) != -1) {
      $message = "[!] Film dengan ID tersebut sudah ada.";
    } else {
      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
          $imagePath = "uploads/" . $fileName;
        } else {
          $message = "[!] Gagal memindahkan file upload.";
        }
      } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $message = "[!] Terjadi error upload dengan kode: " . $_FILES['image']['error'];
      }

      if (empty($message) || strpos($message, '[OK]') !== false) {
        $_SESSION['listFilm'][] = new Film($id, $title, $genre, $rating, $release, $duration, $imagePath);
        $message = "[OK] Film berhasil ditambahkan.";
      }
    }
  }

  // update film yang sudah ada
  else if ($action == 'update') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $rating = floatval($_POST['rating']);
    $release = intval($_POST['release']);
    $duration = intval($_POST['duration']);
    $idx = cariIndexById($_SESSION['listFilm'], $id);

    if ($idx != -1) {
      $imagePath = "";
      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
          $imagePath = "uploads/" . $fileName;
        }
      }
      $_SESSION['listFilm'][$idx]->updateFilm($title, $genre, $rating, $release, $duration, $imagePath);
      $message = "[OK] Data film berhasil diperbarui.";
    }
  }
}

// penanganan get (hapus, edit, cari)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $action = $_GET['action'] ?? '';

  // hapus film dari list
  if ($action == 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $idx = cariIndexById($_SESSION['listFilm'], $id);
    if ($idx != -1) {
      $imagePath = $_SESSION['listFilm'][$idx]->getImage();

      if (!empty($imagePath) && $imagePath != "uploads/default.jpg") {
        $fullPath = __DIR__ . '/' . $imagePath;
        if (file_exists($fullPath)) {
          unlink($fullPath);
        }
      }

      array_splice($_SESSION['listFilm'], $idx, 1);
      $message = "[OK] Film berhasil dihapus.";
    }
  }

  // set data film untuk form edit
  if ($action == 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $idx = cariIndexById($_SESSION['listFilm'], $id);
    if ($idx != -1) {
      $editFilm = $_SESSION['listFilm'][$idx];
    }
  }

  // cari film berdasarkan id
  if ($action == 'cari' && isset($_GET['searchId'])) {
    $searchId = intval($_GET['searchId']);
    $idx = cariIndexById($_SESSION['listFilm'], $searchId);
    if ($idx != -1) {
      $searchResult = $_SESSION['listFilm'][$idx];
    } else {
      $message = "[!] Film tidak ditemukan.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menu Film Bioskop (versi php)</title>
  <style>
    body { font-family: sans-serif; margin: 20px; }
    table, th, td { border: 1px solid #ccc; border-collapse: collapse; padding: 8px; }
    th { background-color: #f2f2f2; }
    .form-box { margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; width: 400px; }
    .img-poster { width: 60px; height: 80px; object-fit: cover; }
  </style>
</head>
<body>

  <h2>=== MENU FILM BIOSKOP (versi php) ===</h2>

  <?php if ($message != ""): ?>
    <p><b><?= $message ?></b></p>
  <?php endif; ?>

  <!-- cari film berdasarkan id -->
  <div class="form-box">
    <h3>Cari Film</h3>
    <form method="GET" action="index.php">
      <input type="hidden" name="action" value="cari">
      <input type="number" name="searchId" placeholder="Masukkan ID Film..." required>
      <button type="submit">Cari</button>
      <a href="index.php"><button type="button">Reset</button></a>
    </form>

    <?php if ($searchResult != null): ?>
      <p><b>Data Ditemukan:</b></p>
      <p>
        ID: <?= $searchResult->getFilmId() ?><br>
        Judul: <?= $searchResult->getTitle() ?><br>
        Genre: <?= $searchResult->getGenre() ?><br>
        Rating: <?= $searchResult->getRating() ?><br>
        Rilis: <?= $searchResult->getRelease() ?><br>
        Durasi: <?= $searchResult->getDuration() ?> mnt<br>
        Path Gambar Poster: <?= $searchResult->getImage() ?>
      </p>
      <img src="<?= $searchResult->getImage() ?>" width="200" alt="Poster"><br>
      <a href="index.php?action=edit&id=<?= $searchResult->getFilmId() ?>">Edit</a> | 
      <a href="index.php?action=hapus&id=<?= $searchResult->getFilmId() ?>" onclick="return confirm('Hapus film ini?')">Hapus</a>
    <?php endif; ?>
  </div>

  <!-- form tambah / update film -->
  <div class="form-box">
    <h3><?= $editFilm ? "Update Film" : "Tambah Film" ?></h3>
    <form method="POST" action="index.php" enctype="multipart/form-data">
      <input type="hidden" name="action" value="<?= $editFilm ? 'update' : 'tambah' ?>">
      
      <p>
        ID Film:<br>
        <input type="number" name="id" value="<?= $editFilm ? $editFilm->getFilmId() : '' ?>" <?= $editFilm ? 'readonly' : 'required' ?>>
      </p>
      <p>
        Judul Film:<br>
        <input type="text" name="title" value="<?= $editFilm ? $editFilm->getTitle() : '' ?>" required>
      </p>
      <p>
        Genre Film:<br>
        <input type="text" name="genre" value="<?= $editFilm ? $editFilm->getGenre() : '' ?>" required>
      </p>
      <p>
        Rating Film:<br>
        <input type="number" step="0.1" name="rating" value="<?= $editFilm ? $editFilm->getRating() : '' ?>" required>
      </p>
      <p>
        Tahun Rilis:<br>
        <input type="number" name="release" value="<?= $editFilm ? $editFilm->getRelease() : '' ?>" required>
      </p>
      <p>
        Durasi (Menit):<br>
        <input type="number" name="duration" value="<?= $editFilm ? $editFilm->getDuration() : '' ?>" required>
      </p>
      <p>
        Gambar Poster (Lokal):<br>
        <input type="file" name="image" accept="image/*">
      </p>

      <button type="submit"><?= $editFilm ? "Simpan Perubahan" : "Tambah Film" ?></button>
      <?php if ($editFilm): ?>
        <a href="index.php"><button type="button">Batal Edit</button></a>
      <?php endif; ?>
    </form>
  </div>

  <!-- tampilkan semua data film -->
  <h3>--- DAFTAR FILM ---</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Poster</th>
        <th>Judul</th>
        <th>Genre</th>
        <th>Rating</th>
        <th>Rilis</th>
        <th>Durasi</th>
        <th>Path File Poster</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($_SESSION['listFilm'])): ?>
        <tr>
          <td colspan="8">Data film masih kosong.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($_SESSION['listFilm'] as $film): ?>
          <tr>
            <td><?= $film->getFilmId() ?></td>
            <td>
              <img src="<?= $film->getImage() ?>" class="img-poster" alt="Poster" onerror="this.src='uploads/default.jpg'">
            </td>
            <td><?= $film->getTitle() ?></td>
            <td><?= $film->getGenre() ?></td>
            <td><?= $film->getRating() ?></td>
            <td><?= $film->getRelease() ?></td>
            <td><?= $film->getDuration() ?> mnt</td>
            <td><code><?= $film->getImage() ?></code></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>