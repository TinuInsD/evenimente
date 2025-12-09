<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM categorii_evenimente");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Categorii Evenimente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Categorii Evenimente</h2>
  <a href="add_category.php" class="btn btn-success mb-3">Adaugă Categorie</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nume</th>
        <th>Acțiuni</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nume']) ?></td>
        <td>
          <a href="edit_category.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editează</a>
          <a href="delete_category.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ești sigur că vrei să ștergi această categorie?')">Șterge</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
