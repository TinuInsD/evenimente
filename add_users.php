<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id']) || $_SESSION['tip'] !== 'admin') {
  header("Location: index_admin.php");
  exit;
}

$mesaj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $parola = password_hash($_POST['parola'], PASSWORD_DEFAULT);
  $tip = mysqli_real_escape_string($conn, $_POST['tip']);

  $verificare = mysqli_query($conn, "SELECT id FROM utilizatori WHERE username = '$username' OR email = '$email'");
  if (mysqli_num_rows($verificare) > 0) {
    $mesaj = "Username-ul sau email-ul există deja.";
  } else {

    $stmt = $conn->prepare("SELECT id FROM roluri WHERE nume = ?");
    $stmt->bind_param("s", $tip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $rol = $result->fetch_assoc();
      $id_rol = $rol['id'];

      $stmt2 = $conn->prepare("INSERT INTO utilizatori (username, email, parola, id_rol) VALUES (?, ?, ?, ?)");
      $stmt2->bind_param("sssi", $username, $email, $parola, $id_rol);
      if ($stmt2->execute()) {
        $id_utilizator = $conn->insert_id;

        $stmt3 = $conn->prepare("INSERT INTO drepturi (id_utilizator, id_pagina)
                                 SELECT ?, id_pagina FROM drepturi_rol WHERE id_rol = ?");
        $stmt3->bind_param("ii", $id_utilizator, $id_rol);
        $stmt3->execute();

        $mesaj = "Utilizator adăugat cu succes.";
      } else {
        $mesaj = "Eroare la adăugare: " . mysqli_error($conn);
      }
    } else {
      $mesaj = "Rol invalid.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Adaugă Utilizator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Adaugă un Utilizator Nou</h2>

  <?php if ($mesaj): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mesaj) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" name="username" id="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="parola" class="form-label">Parolă</label>
      <input type="password" name="parola" id="parola" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="tip" class="form-label">Tip</label>
      <select name="tip" id="tip" class="form-select" required>
        <option value="user">Utilizator</option>
        <option value="admin">Admin</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Adaugă Utilizator</button>
    <a href="view_users.php" class="btn btn-secondary">Anulează</a>
  </form>
</div>
</body>
</html>
