<?php include 'user_protectie.php';

include 'db.php';
include 'navbar_user.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}

$user_id = (int) $_SESSION['user_id'];
$mesaj = '';

// Adăugare fonduri
if (isset($_POST['adauga_fonduri'])) {
  $suma = floatval($_POST['suma_fonduri']);
  if ($suma > 0) {
    mysqli_query($conn, "UPDATE utilizatori SET fonduri = fonduri + $suma WHERE id = $user_id");
    $mesaj = "Fonduri adăugate cu succes!";
  } else {
    $mesaj = "Introduceți o sumă validă.";
  }
}

// Actualizare avatar
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
  $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
  $filename = 'avatar_' . $user_id . '.' . $ext;
  move_uploaded_file($_FILES['avatar']['tmp_name'], 'uploads/' . $filename);
  mysqli_query($conn, "UPDATE utilizatori SET avatar='$filename' WHERE id=$user_id");
  $mesaj = "Avatar actualizat!";
}

// Schimbare parolă
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

if (isset($_POST['refund_bilet'])) {
  $id_bilet_cumparat = (int)$_POST['id_bilet_cumparat'];
  $res = mysqli_query($conn, "
    SELECT bc.*, b.pret, TIMESTAMPDIFF(HOUR, bc.data_achizitiei, NOW()) AS ore_trecute
    FROM bilete_cumparate bc
    JOIN bilete b ON bc.bilet_id = b.id
    WHERE bc.id = $id_bilet_cumparat AND bc.user_id = $user_id
  ");

  $bilet = mysqli_fetch_assoc($res);
  if ($bilet) {
    if ($bilet['ore_trecute'] <= 24) {
      $suma_refund = $bilet['cantitate'] * $bilet['pret'];
      mysqli_query($conn, "UPDATE utilizatori SET fonduri = fonduri + $suma_refund WHERE id = $user_id");
      mysqli_query($conn, "DELETE FROM bilete_cumparate WHERE id = $id_bilet_cumparat");
      $mesaj = "Refund realizat cu succes: $suma_refund RON a fost adăugat în cont.";
    } else {
      $mesaj = "Refund indisponibil: au trecut mai mult de 24 de ore de la achiziție.";
    }
  } else {
    $mesaj = "Eroare: biletul nu a fost găsit sau nu îți aparține.";
  }
}

$result = mysqli_query($conn, "SELECT username, email, avatar, fonduri FROM utilizatori WHERE id=$user_id");
$user = mysqli_fetch_assoc($result);
$mesaje_user = mysqli_query($conn, "
  SELECT mesaj, data_trimitere, status 
  FROM mesaje_contact 
  WHERE user_id = $user_id
  ORDER BY data_trimitere DESC
");

$bilete = mysqli_query($conn, "
  SELECT bc.*, b.tip, b.pret, e.nume AS eveniment, e.data, e.locatie
  FROM bilete_cumparate bc
  JOIN bilete b ON bc.bilet_id = b.id
  JOIN evenimente e ON bc.eveniment_id = e.id
  WHERE bc.user_id = $user_id
  ORDER BY bc.data_achizitiei DESC
");
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
    <p><strong>Fonduri disponibile:</strong> <?= number_format($user['fonduri'], 2) ?> RON</p>
    <form method="POST" class="mb-4">
      <label for="suma_fonduri" class="form-label">Adaugă fonduri în cont:</label>
      <div class="input-group">
        <input type="number" step="0.01" min="1" name="suma_fonduri" class="form-control" placeholder="Ex: 100.00" required>
        <button type="submit" name="adauga_fonduri" class="btn btn-success">Încarcă</button>
      </div>
    </form>
    <p><strong>Avatar:</strong></p>
    <?php if (!empty($user['avatar']) && file_exists('uploads/' . $user['avatar'])): ?>
      <img src="uploads/<?= htmlspecialchars($user['avatar']) ?>" class="avatar-preview" alt="Avatar">
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

  <hr class="my-5">

  <h4>🎟️ Biletele mele</h4>
  <?php if (mysqli_num_rows($bilete) === 0): ?>
    <p><em>Nu ai cumpărat încă bilete.</em></p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead class="table-light">
        <tr>
          <th>Eveniment</th>
          <th>Data</th>
          <th>Locație</th>
          <th>Cantitate</th>
          <th>Total</th>
          <th>Data cumpărării</th>
          <th>Refund</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($b = mysqli_fetch_assoc($bilete)): ?>
          <tr>
            <td><?= htmlspecialchars($b['eveniment']) ?></td>
            <td><?= htmlspecialchars($b['data']) ?></td>
            <td><?= htmlspecialchars($b['locatie']) ?></td>
            <td><?= (int)$b['cantitate'] ?></td>
            <td><?= number_format($b['cantitate'] * $b['pret'], 2) ?> RON</td>
            <td><?= htmlspecialchars($b['data_achizitiei']) ?></td>
            <td>
              <form method="POST" onsubmit="return confirm('Sigur dorești refund pentru acest bilet?')">
                <input type="hidden" name="id_bilet_cumparat" value="<?= $b['id'] ?>">
                <button type="submit" name="refund_bilet" class="btn btn-sm btn-danger">💸 Refund</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
  <hr class="my-5">

<h4>📨 Mesajele tale trimise către admin</h4>

<?php if (mysqli_num_rows($mesaje_user) === 0): ?>
  <p><em>Nu ai trimis niciun mesaj prin formularul de contact.</em></p>
<?php else: ?>
  <table class="table table-bordered mt-3">
    <thead class="table-light">
      <tr>
        <th>Mesaj</th>
        <th>Data trimiterii</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($m = mysqli_fetch_assoc($mesaje_user)) : ?>
        <tr>
          <td><?= nl2br(htmlspecialchars($m['mesaj'])) ?></td>
          <td><?= htmlspecialchars($m['data_trimitere']) ?></td>
          <td>
            <?php
              switch ($m['status']) {
                case 'Rezolvat':
                  echo '<span class="badge bg-success">Rezolvat</span>';
                  break;
                case 'În lucru':
                  echo '<span class="badge bg-warning text-dark">În lucru</span>';
                  break;
                case 'Ignorat':
                  echo '<span class="badge bg-secondary">Ignorat</span>';
                  break;
                default:
                  echo '<span class="badge bg-danger">Nerezolvat</span>';
              }
            ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php endif; ?>
</div>
</body>
</html>
