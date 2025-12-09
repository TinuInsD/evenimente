<?php 
include 'user_protectie.php'; 

include 'db.php';
include 'navbar_user.php';

if (!isset($_SESSION['user_id'])) {
  die("Trebuie să fii autentificat pentru a lăsa un feedback.");
}

$user_id = $_SESSION['user_id'];
$evenimente_res = mysqli_query($conn, "SELECT id, nume FROM evenimente");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_eveniment = (int) $_POST['id_eveniment'];
  $mesaj = mysqli_real_escape_string($conn, $_POST['mesaj']);
  $rating = (int) $_POST['rating'];
  $data = date('Y-m-d');

  if ($rating < 1 || $rating > 5) {
    die("Ratingul trebuie să fie între 1 și 5.");
  }

  $user_res = mysqli_query($conn, "SELECT username FROM utilizatori WHERE id = $user_id");
  $user = mysqli_fetch_assoc($user_res);
  $nume_utilizator = mysqli_real_escape_string($conn, $user['username']);
  $insert = mysqli_query($conn, "
    INSERT INTO feedback (id_eveniment, nume_utilizator, mesaj, data, rating)
    VALUES ($id_eveniment, '$nume_utilizator', '$mesaj', '$data', $rating)
  ");

  if ($insert) {
    $success = true;
  } else {
    $error = "A apărut o eroare la trimiterea feedbackului.";
  }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Lasă feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Lasă un feedback pentru un eveniment</h2>

  <?php if (isset($success)): ?>
    <div class="alert alert-success">Feedbackul a fost trimis cu succes!</div>
  <?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="id_eveniment" class="form-label">Eveniment</label>
      <select class="form-select" id="id_eveniment" name="id_eveniment" required>
        <option value="">Selectează un eveniment</option>
        <?php while ($e = mysqli_fetch_assoc($evenimente_res)): ?>
          <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nume']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="mesaj" class="form-label">Mesaj</label>
      <textarea class="form-control" id="mesaj" name="mesaj" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label for="rating" class="form-label">Rating (1 - 5)</label>
      <select class="form-select" id="rating" name="rating" required>
        <option value="">Alege rating</option>
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <option value="<?= $i ?>"><?= $i ?> stele</option>
        <?php endfor; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Trimite feedback</button>
  </form>
</div>
</body>
</html>
