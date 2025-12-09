<?php
session_start();
include 'navbar.php';
include 'db.php';
if (!isset($_SESSION['user_id']) || (int)$_SESSION['id_rol'] !== 1) {
  header("Location: index_admin.php");
  exit;
}

$sql = "SELECT * FROM mesaje_contact ORDER BY data_trimitere DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Mesaje Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <div class="mt-5">
    <h2 class="mb-4">Mesaje primite prin formularul de contact</h2>

    <?php if (mysqli_num_rows($result) === 0): ?>
      <div class="alert alert-info">Nu există mesaje de afișat.</div>
    <?php else: ?>
      <table class="table table-bordered table-striped">
        <thead class="table-primary">
  <tr>
    <th>ID</th>
    <th>Nume</th>
    <th>Email</th>
    <th>Mesaj</th>
    <th>Data trimiterii</th>
    <th>Status</th>
    <th>Acțiuni</th>
  </tr>
</thead>
<tbody>
  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['nume']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['mesaj'])) ?></td>
      <td><?= htmlspecialchars($row['data_trimitere']) ?></td>
      <td><?= htmlspecialchars($row['status']) ?></td>
      <td>
        <a href="delete_message.php?id=<?= $row['id'] ?>" 
           class="btn btn-sm btn-danger"
           onclick="return confirm('Ești sigur că vrei să ștergi acest mesaj?')">
          Șterge
        </a>
         <a href="edit_status.php?id=<?= $row['id'] ?>" 
           class="btn btn-sm btn-info">
           Status
      </td>
    </tr>
  <?php endwhile; ?>
</tbody>

          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['nume']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['mesaj'])) ?></td>
              <td><?= htmlspecialchars($row['data_trimitere']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <a href="index_admin.php" class="btn btn-secondary mt-3">Înapoi la Panoul de control</a>
  </div>
</body>
</html>
