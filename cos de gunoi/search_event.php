<?php
include 'db.php';

$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

$sql = "SELECT * FROM evenimente WHERE nume LIKE '%$q%'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Rezultate Căutare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-primary">Rezultate pentru: <strong><?= htmlspecialchars($q) ?></strong></h2>
  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="row">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm border-primary">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['nume']) ?></h5>
              <p class="card-text">
                <strong>Data:</strong> <?= $row['data'] ?><br>
                <strong>Locatie:</strong> <?= htmlspecialchars($row['locatie']) ?><br>
                <strong>Organizator:</strong> <?= htmlspecialchars($row['organizator']) ?>
              </p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Nu s-au găsit evenimente cu acest nume.</div>
  <?php endif; ?>
  <a href="index.html" class="btn btn-secondary ms-2">Înapoi</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
