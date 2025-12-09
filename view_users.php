<?php
session_start();
include 'navbar.php';
include 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['id_rol'] != 1) {
  header("Location: index_admin.php");
  exit;
}

$sql = "SELECT utilizatori.*, roluri.nume AS rol_nume
        FROM utilizatori
        LEFT JOIN roluri ON utilizatori.id_rol = roluri.id
        ORDER BY utilizatori.id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Utilizatori - Administrare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .avatar-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
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
  <h2 class="mb-4">Lista Utilizatorilor</h2>
  <table class="table table-bordered table-hover">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Avatar</th>
        <th>Username</th>
        <th>Tip</th>
        <th>Acțiuni</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td>
            <?php if (!empty($row['avatar']) && file_exists('uploads/' . $row['avatar'])): ?>
              <img src="uploads/<?= htmlspecialchars($row['avatar']) ?>" alt="Avatar" class="avatar-img">
            <?php else: ?>
              <span style="color: #888;">Fără avatar</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['rol_nume'] ?? 'Necunoscut') ?></td>
          <td>
            <a href="edit_users.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editează</a>
            <a href="delete_users.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ești sigur că vrei să ștergi acest utilizator?')">Șterge</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="index_admin.php" class="btn btn-secondary">Înapoi Acasa</a>
  <a href="add_users.php" class="btn btn-secondary">Adaugă (manual) un Utilizator</a>
</div>

</body>
</html>
