<?php
session_start();
include 'db.php';
include 'navbar.php';

// Verificăm dacă utilizatorul este admin
if (!isset($_SESSION['user_id']) || $_SESSION['id_rol'] != 1) {
  die("Acces interzis. Doar adminii pot vizualiza această pagină.");
}

// Ștergere feedback
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  mysqli_query($conn, "DELETE FROM feedback WHERE id = $id");
  header("Location: view_feedback.php?deleted=1");
  exit;
}

// Preluare feedbackuri
$result = mysqli_query($conn, "
  SELECT f.*, e.nume AS nume_eveniment
  FROM feedback f
  JOIN evenimente e ON f.id_eveniment = e.id
  ORDER BY f.data DESC
");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Administrare Feedbackuri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<style>
    body {
      background-image: url('images/imagine evenimente admin.webp');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      min-height: 100vh;
    }
  </style>

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0"><i class="bi bi-chat-left-text-fill"></i> Feedback-uri primite</h4>
    </div>

    <div class="card-body">

      <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Feedback șters cu succes.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Închide"></button>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>Eveniment</th>
              <th>Utilizator</th>
              <th>Rating</th>
              <th>Mesaj</th>
              <th>Data</th>
              <th>Acțiuni</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= htmlspecialchars($row['nume_eveniment']) ?></td>
                <td><?= htmlspecialchars($row['nume_utilizator']) ?></td>
                <td>
                  <?php for ($i = 0; $i < $row['rating']; $i++): ?>
                    <i class="bi bi-star-fill text-warning"></i>
                  <?php endfor; ?>
                </td>
                <td class="text-start"><?= nl2br(htmlspecialchars($row['mesaj'])) ?></td>
                <td><?= htmlspecialchars($row['data']) ?></td>
                <td>
                  <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Sigur vrei să ștergi acest feedback?');">
                    <i class="bi bi-trash"></i> Șterge
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
