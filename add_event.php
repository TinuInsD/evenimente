<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $time = mysqli_real_escape_string($conn, $_POST['time']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $categorie_id = intval($_POST['categorie_id']);
  $visibility = mysqli_real_escape_string($conn, $_POST['visibility']);
  $imagine = '';
  $organizator = "Admin";
}

$sql = "INSERT INTO evenimente (nume, descriere, data, ora, locatie, categorie, vizibilitate, organizator, imagine)
        VALUES ('$title', '$description', '$date', '$time', '$location', '$categorie_id', '$visibility', '$organizator', '$imagine')";

if (mysqli_query($conn, $sql)) {
  header("Location: index_admin.php?succes=1");
  exit;
} else {
  echo "Eroare la inserare: " . mysqli_error($conn);
}

  $success = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Rezultat Adăugare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-body text-center">
      <h4 class="mb-4">Rezultat Adăugare Eveniment</h4>

      <?php if (isset($success) && $success): ?>
        <div class="alert alert-success">✅ Evenimentul a fost adăugat cu succes!</div>
      <?php else: ?>
        <div class="alert alert-danger">❌ Eroare la adăugarea evenimentului.</div>
      <?php endif; ?>

      <div class="d-flex justify-content-between mt-4">
        <a href="add_event_form.php" class="btn btn-primary">➕ Adaugă alt eveniment</a>
        <a href="index_admin.php" class="btn btn-outline-secondary">🏠 Înapoi Acasă</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
