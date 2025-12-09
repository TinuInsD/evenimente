<?php include 'admin_protectie.php';  
include 'navbar.php';
?>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_event_id'])) {
  $id = (int)$_POST['delete_event_id'];
  $delete = mysqli_query($conn, "DELETE FROM evenimente WHERE id = $id");

  if ($delete) {
    header("Location: view_events_admin.php?deleted=1");
    exit;
  } else {
    echo "<div class='alert alert-danger text-center'>Eroare la ștergere.</div>";
  }
}

$result = mysqli_query($conn, "
  SELECT e.*, c.nume AS categorie_nume
  FROM evenimente e
  LEFT JOIN categorii_evenimente c ON e.categorie = c.id
");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Evenimente Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('images/imagine evenimente admin.webp');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      min-height: 100vh;
    }
    .overlay {
      background-color: rgba(255, 255, 255, 0.85); /* ușor alb transparent pentru lizibilitate */
      min-height: 100vh;
      padding: 2rem 0;
    }
    .card {
      height: 100%;
      background-color: lightgray; /* ușor alb transparent pentru lizibilitate */

    }
    .card-body {
      flex-grow: 1;
    }
    .card-footer {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 1rem;
      border-top: none;
      background-color: transparent;
    }
  </style>
</head>
<body>
<div class="overlay">
  <div class="container">
    <h2 class="mb-4">Lista Evenimente</h2>

    <?php if (isset($_GET['deleted'])): ?>
      <div class="alert alert-success">Evenimentul a fost șters cu succes.</div>
    <?php endif; ?>

    <div class="row">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow d-flex flex-column">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['nume']) ?></h5>
              <p class="card-text">
                <strong>ID:</strong> <?= $row['id'] ?><br>
                <strong>Locație:</strong> <?= htmlspecialchars($row['locatie']) ?><br>
                <strong>Data:</strong> <?= $row['data'] ?><br>
                <strong>Ora:</strong> <?= $row['ora'] ?><br>
                <strong>Categorie:</strong> <?= htmlspecialchars($row['categorie_nume']) ?><br>
                <strong>Organizator:</strong> <?= htmlspecialchars($row['organizator']) ?>
              </p>
              <p class="card-text"><em><?= nl2br(htmlspecialchars($row['descriere'])) ?></em></p>
            </div>

            <div class="card-footer">
              <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Editează</a>

              <form method="POST" onsubmit="return confirm('Ești sigur că vrei să ștergi acest eveniment?');" style="margin: 0;">
                <input type="hidden" name="delete_event_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">🗑️ Șterge</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>
</body>
</html>
