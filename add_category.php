<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nume = trim($_POST['nume']);
  if (!empty($nume)) {
    $stmt = $conn->prepare("INSERT INTO categorii_evenimente (nume) VALUES (?)");
    $stmt->bind_param("s", $nume);
    $stmt->execute();
    header("Location: view_categories.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Adaugă Categorie</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Adaugă o nouă Categorie</h2>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Nume categorie</label>
      <input type="text" name="nume" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Adaugă</button>
    <a href="view_categories.php" class="btn btn-secondary">Anulează</a>
  </form>
</div>
</body>
</html>
