<?php
include 'db.php';
include 'navbar_user.php';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Detalii Eveniment - Evenimente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1>Aici poti vedea locatia evenimentelor</h1>
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
      </div>
    </div>
    <div class="mb-4">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <a href="view_events.php" class="btn btn-secondary">Vezi Evenimentele Disponibile</a>
  </div>
  <footer class="bg-light text-center py-3 mt-4">
    <div class="container">
      &copy; 2025 Evenimente.
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
