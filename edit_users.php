<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['id_rol'] != 1) {
  header("Location: ../index.php");
  exit;
}

include 'db.php';
include 'navbar.php';

$id = intval($_GET['id'] ?? 0);
$mesaj = '';

if ($id > 0) {
  $sql = "SELECT utilizatori.*, roluri.nume AS rol_nume, roluri.id AS rol_id FROM utilizatori 
          LEFT JOIN roluri ON utilizatori.id_rol = roluri.id
          WHERE utilizatori.id = $id";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $rol_nume = mysqli_real_escape_string($conn, $_POST['tip']); // "admin" sau "user"
  $stmt = $conn->prepare("SELECT id FROM roluri WHERE nume = ?");
  $stmt->bind_param("s", $rol_nume);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $rol = $result->fetch_assoc();
    $id_rol = $rol['id'];

    $update = "UPDATE utilizatori SET username='$username', id_rol=$id_rol WHERE id = $id";
    if (mysqli_query($conn, $update)) {
      $mesaj = "Utilizator actualizat cu succes.";
      $user['username'] = $username;
      $user['rol_nume'] = $rol_nume;
      $user['rol_id'] = $id_rol;
      
      if ($_SESSION['user_id'] == $id) {
        $_SESSION['id_rol'] = $id_rol;
      }

    } else {
      $mesaj = "Eroare la actualizare: " . mysqli_error($conn);
    }
  } else {
    $mesaj = "Rol invalid selectat.";
  }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <title>Editează Utilizator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Editează Utilizator</h2>

    <?php if ($mesaj): ?>
      <div class="alert alert-info"><?= htmlspecialchars($mesaj) ?></div>
    <?php endif; ?>

    <?php if (!empty($user)): ?>
      <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input 
            type="text" 
            id="username" 
            name="username" 
            class="form-control" 
            value="<?= htmlspecialchars($user['username']) ?>" 
            required 
          />
          <div class="invalid-feedback">Te rugăm să introduci un username valid.</div>
        </div>

        <div class="mb-3">
          <label for="tip" class="form-label">Tip</label>
          <select id="tip" name="tip" class="form-select" required>
            <option value="user" <?= ($user['rol_nume'] === 'user') ? 'selected' : '' ?>>Utilizator</option>
            <option value="admin" <?= ($user['rol_nume'] === 'admin') ? 'selected' : '' ?>>Admin</option>
          </select>
          <div class="invalid-feedback">Te rugăm să selectezi un rol.</div>
        </div>

        <button type="submit" class="btn btn-primary">Salvează</button>
        <a href="view_users.php" class="btn btn-secondary">Anulează</a>
        <a href="view_users.php" class="btn btn-secondary">Înapoi la lista utilizatorilor</a>
      </form>
    <?php else: ?>
      <div class="alert alert-warning">Utilizatorul nu a fost găsit.</div>
      <a href="view_users.php" class="btn btn-secondary">Înapoi la lista utilizatorilor</a>
    <?php endif; ?>
  </div>

  <script>
    // Bootstrap validation
    (() => {
      'use strict'
      const forms = document.querySelectorAll('.needs-validation')
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</body>
</html>
