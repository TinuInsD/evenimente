<?php 
include 'admin_protectie.php';
include 'db.php';
include 'navbar.php';

if (!isset($_GET['id'])) {
  echo "ID eveniment lipsă.";
  exit;
}

$id = (int)$_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $time = mysqli_real_escape_string($conn, $_POST['time']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $visibility = mysqli_real_escape_string($conn, $_POST['visibility']);

  $update = mysqli_query($conn, "
    UPDATE evenimente 
    SET nume = '$title', descriere = '$description', data = '$date', ora = '$time',
        locatie = '$location', categorie = '$category', vizibilitate = '$visibility'
    WHERE id = $id
  ");

  if ($update) {
    header("Location: view_events_admin.php?updated=1");
    exit;
  } else {
    $error = "Eroare la actualizare.";
  }
}

$event = mysqli_query($conn, "SELECT * FROM evenimente WHERE id = $id");
$eventData = mysqli_fetch_assoc($event);
$categories = mysqli_query($conn, "SELECT * FROM categorii_evenimente");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Editează Eveniment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h3>📝 Editează Evenimentul</h3>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Titlul</label>
      <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($eventData['nume']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Descriere</label>
      <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($eventData['descriere']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Data</label>
      <input type="date" name="date" class="form-control" required value="<?= $eventData['data'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Ora</label>
      <input type="time" name="time" class="form-control" value="<?= $eventData['ora'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Locația</label>
      <input type="text" name="location" class="form-control" required value="<?= htmlspecialchars($eventData['locatie']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Categorie</label>
      <select name="category" class="form-select" required>
        <option value="">Alege categoria</option>
        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
          <option value="<?= $cat['id'] ?>" <?= ($eventData['categorie'] == $cat['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nume']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Vizibilitate</label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="visibility" value="public"
          <?= ($eventData['vizibilitate'] === 'public') ? 'checked' : '' ?>>
        <label class="form-check-label">Public</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="visibility" value="private"
          <?= ($eventData['vizibilitate'] === 'private') ? 'checked' : '' ?>>
        <label class="form-check-label">Privat</label>
      </div>
    </div>

    <div class="d-flex justify-content-between">
      <a href="view_events_admin.php" class="btn btn-secondary">Înapoi</a>
      <button type="submit" class="btn btn-primary">💾 Salvează Modificările</button>
    </div>
  </form>
</div>

</body>
</html>
