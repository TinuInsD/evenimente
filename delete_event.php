<?php
include 'db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $event_id = intval($_POST['id'] ?? 0);

  if ($event_id > 0) {
    $sql = "DELETE FROM evenimente WHERE id = $event_id";
    $success = mysqli_query($conn, $sql);
    if (!$success) {
      $error = true;
    }
  } else {
    $error = true;
  }
} else {
  header("Location: delete-event.html");
  exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Ștergere Eveniment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="admin/index.php">Admin Evenimente</a>
    </div>
  </nav>

  <div class="container mt-5">
    <?php if ($success): ?>
      <div class="alert alert-success">
        Evenimentul a fost șters cu succes.
      </div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger">
        A apărut o eroare. Verifică ID-ul evenimentului și încearcă din nou.
      </div>
    <?php endif; ?>

    <a href="delete-event-admin.html" class="btn btn-danger mt-3">Șterge alt eveniment</a>
    <a href="index_admin.php" class="btn btn-secondary mt-3">Înapoi la Dashboard</a>
  </div>

  <footer class="bg-light text-center py-3 mt-5">
    <div class="container">
      &copy; 2025 Admin Evenimente. Toate drepturile rezervate.
    </div>
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
