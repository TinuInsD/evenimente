<?php
session_start();
include 'db.php';
include 'navbar.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}

$user_id = $_SESSION['user_id'];
$mesaj = '';

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
  $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
  $filename = 'avatar_' . $user_id . '.' . $ext;
  move_uploaded_file($_FILES['avatar']['tmp_name'], 'uploads/' . $filename);
  mysqli_query($conn, "UPDATE utilizatori SET avatar='$filename' WHERE id=$user_id");
  $mesaj = "Avatar actualizat!";
}

if (isset($_POST['old_pass'], $_POST['new_pass'], $_POST['confirm_pass'])) {
  $old = $_POST['old_pass'];
  $new = $_POST['new_pass'];
  $confirm = $_POST['confirm_pass'];
  $res = mysqli_query($conn, "SELECT parola FROM utilizatori WHERE id=$user_id");
  $data = mysqli_fetch_assoc($res);

  if (!password_verify($old, $data['parola'])) {
    $mesaj = "Parola actuală este greșită.";
  } elseif ($new !== $confirm) {
    $mesaj = "Parolele nu coincid.";
  } else {
    $hash = password_hash($new, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE utilizatori SET parola='$hash' WHERE id=$user_id");
    $mesaj = "Parola a fost schimbată cu succes.";
  }
}

// date utilizator
$result = mysqli_query($conn, "SELECT username, email, avatar FROM utilizatori WHERE id=$user_id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Contul Meu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .avatar-preview {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ccc;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2>👤 Contul meu</h2>

  <?php if ($mesaj): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mesaj) ?></div>
  <?php endif; ?>

  <div class="mb-4">
    <p><strong>Nume utilizator:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Avatar:</strong></p>
    <?php if (!empty($user['avatar']) && file_exists('uploads/' . $user['avatar'])): ?>
      <img src="uploads/<?= $user['avatar'] ?>" class="avatar-preview" alt="Avatar">
    <?php else: ?>
      <p><em>Niciun avatar încărcat</em></p>
    <?php endif; ?>
  </div>

  <form method="POST" enctype="multipart/form-data" class="mb-4">
    <label for="avatar" class="form-label">Încarcă un avatar nou:</label>
    <input type="file" name="avatar" class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Actualizează avatar</button>
  </form>

  <hr>

  <h4>🔒 Schimbă parola</h4>
  <form method="POST">
    <input type="password" name="old_pass" class="form-control mb-2" placeholder="Parola actuală" required>
    <input type="password" name="new_pass" class="form-control mb-2" placeholder="Parola nouă" required>
    <input type="password" name="confirm_pass" class="form-control mb-3" placeholder="Confirmare parolă" required>
    <button type="submit" class="btn btn-warning">Schimbă parola</button>
  </form>
</div>
</body>
</html>
