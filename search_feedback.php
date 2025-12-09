<?php
include 'db.php';

// Prevenție SQL Injection
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

// Interogare
$sql = "SELECT * FROM feedback WHERE nume_utilizator LIKE '%$q%'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <title>Rezultate Căutare Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Rezultate pentru: "<strong><?= htmlspecialchars($q) ?></strong>"</h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <ul class="list-group">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <li class="list-group-item">
          <strong><?= htmlspecialchars($row['nume_utilizator']) ?></strong> – 
          <?= htmlspecialchars($row['mesaj']) ?>
          <br><small class="text-muted">Rating: <?= (int)$row['rating'] ?></small>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <div class="alert alert-warning mt-3">Nu s-au găsit feedback-uri pentru acest nume.</div>
  <?php endif; ?>

  <div class="mt-4">
    <a href="search_feedback.html" class="btn btn-secondary">Înapoi</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
