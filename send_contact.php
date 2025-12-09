<?php
include 'db.php';
include 'navbar_user.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nume = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
  $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
  $mesaj = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

  $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : "NULL";

  if (!empty($nume) && !empty($email) && !empty($mesaj)) {
    $sql = "INSERT INTO mesaje_contact (user_id, nume, email, mesaj, data_trimitere) 
            VALUES ($user_id, '$nume', '$email', '$mesaj', NOW())";
    $success = mysqli_query($conn, $sql);
    if (!$success) $error = true;
  } else {
    $error = true;
  }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Mesaj Trimis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 mb-5">
  <?php if ($success): ?>
    <div class="alert alert-success">
      ✅ Mesajul a fost trimis cu succes! Vom reveni în cel mai scurt timp.
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger">
      ❌ A apărut o eroare. Verifică dacă toate câmpurile sunt completate corect și încearcă din nou.
    </div>
  <?php endif; ?>

  <a href="index.php" class="btn btn-secondary mt-3">Înapoi la Acasă</a>
</div>

<footer class="bg-primary text-white text-center py-3 mt-4">
  <div class="container">
    &copy; 2025 Evenimente. Toate drepturile rezervate.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
