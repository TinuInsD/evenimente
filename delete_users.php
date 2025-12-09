<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['id_rol'] != 1) {
  header("Location: ../index.php");
  exit;
}

include 'db.php';
include 'navbar.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0 && $id != $_SESSION['user_id']) {
  $sql = "DELETE FROM utilizatori WHERE id = $id";
  if (mysqli_query($conn, $sql)) {
    header("Location: view_users.php");
    exit;
  } else {
    $mesaj = "Eroare la ștergere.";
  }
} else {
  $mesaj = "Nu poți șterge contul tău propriu sau ID invalid.";
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Șterge Utilizator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="alert alert-danger">
      <?= htmlspecialchars($mesaj ?? 'Eroare necunoscută.') ?>
    </div>
    <a href="view_users.php" class="btn btn-secondary">Înapoi</a>
  </div>
</body>
</html>
