<?php
include 'db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nume = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
  $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
  $mesaj = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

  if (!empty($nume) && !empty($email) && !empty($mesaj)) {
    $data = date('Y-m-d H:i:s'); // data si ora curenta
    $sql = "INSERT INTO mesaje_contact (nume, email, mesaj, data_trimitere) 
            VALUES ('$nume', '$email', '$mesaj', '$data')";
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="welcome.php">Evenimente</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContact">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContact">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="welcome.php">Acasă</a></li>
          <li class="nav-item"><a class="nav-link" href="despre-noi-nelogat.html">Despre Noi</a></li>
          <li class="nav-item"><a class="nav-link" href="faq-nelogat.html">FAQ</a></li>
          <li class="nav-item"><a class="nav-link active fw-semibold text-white" href="contact-nelogat.html">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Rezultat -->
  <div class="container mt-5 mb-5">
    <?php if ($success): ?>
      <div class="alert alert-success">
        Mesajul a fost trimis cu succes! Vom reveni în cel mai scurt timp.
      </div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger">
        A apărut o eroare. Verifică dacă toate câmpurile sunt completate corect și încearcă din nou.
      </div>
    <?php else: ?>
      <div class="alert alert-warning">
        Acces direct neautorizat. Vă rugăm folosiți formularul de <a href="contact.html">contact</a>.
      </div>
    <?php endif; ?>

    <a href="welcome.php" class="btn btn-secondary mt-3">Înapoi Acasă</a>
  </div>

  <!-- Footer -->
  <footer class="bg-primary text-white text-center py-3 mt-4">
    <div class="container">
      &copy; 2025 Evenimente. Toate drepturile rezervate.
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
