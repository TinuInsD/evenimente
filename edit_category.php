<?php
include 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM categorii_evenimente WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$rezultat = $stmt->get_result();
$categorie = $rezultat->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nume = trim($_POST['nume']);
  if (!empty($nume)) {
    $stmt = $conn->prepare("UPDATE categorii_evenimente SET nume = ? WHERE id = ?");
    $stmt->bind_param("si", $nume, $id);
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
  <title>Editează Categorie</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Editează Categorie</h2>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Nume categorie</label>
      <input type="text" name="nume" class="form-control" value="<?= htmlspecialchars($categorie['nume']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvează</button>
    <a href="view_categories.php" class="btn btn-secondary">Anulează</a>
  </form>
</div>
</body>
</html>
