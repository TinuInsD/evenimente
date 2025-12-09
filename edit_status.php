<?php
session_start();
include 'db.php';
include 'navbar.php';

if (!isset($_SESSION['user_id']) || (int)$_SESSION['id_rol'] !== 1) {
  header("Location: index_admin.php");
  exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: view_messages.php");
  exit;
}

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $query = "UPDATE mesaje_contact SET status='$status' WHERE id=$id";

  if (mysqli_query($conn, $query)) {
    header("Location: view_messages.php?status_updated=1");
    exit;
  } else {
    $error = "Eroare la actualizarea statusului.";
  }
}

$result = mysqli_query($conn, "SELECT * FROM mesaje_contact WHERE id=$id LIMIT 1");
if (!$result || mysqli_num_rows($result) === 0) {
  echo "Mesajul nu există.";
  exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Editează Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Schimbă Statusul Mesajului</h2>

  <?php if (isset($error)) : ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="status" class="form-label">Status</label>
      <select name="status" id="status" class="form-select" required>
        <option value="Nerezolvat" <?= $row['status'] === 'Nerezolvat' ? 'selected' : '' ?>>Nerezolvat</option>
        <option value="În lucru" <?= $row['status'] === 'În lucru' ? 'selected' : '' ?>>În lucru</option>
        <option value="Rezolvat" <?= $row['status'] === 'Rezolvat' ? 'selected' : '' ?>>Rezolvat</option>
        <option value="Ignorat" <?= $row['status'] === 'Ignorat' ? 'selected' : '' ?>>Ignorat</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizează</button>
    <a href="view_messages.php" class="btn btn-secondary">Anulează</a>
  </form>
</div>
</body>
</html>
