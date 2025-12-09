<?php
include 'db.php';

$id_eveniment = intval($_POST['id_eveniment']);
$nume = mysqli_real_escape_string($conn, $_POST['nume_utilizator']);
$mesaj = mysqli_real_escape_string($conn, $_POST['mesaj']);
$data = $_POST['data'];
$rating = intval($_POST['rating']);

if (empty($id_eveniment) || empty($nume) || empty($mesaj) || empty($data) || $rating < 1 || $rating > 5) {
    $message = "Toate câmpurile sunt obligatorii și ratingul trebuie să fie între 1 și 5.";
    $success = false;
} else {
    $sql = "INSERT INTO feedback (id_eveniment, nume_utilizator, mesaj, data, rating)
            VALUES ($id_eveniment, '$nume', '$mesaj', '$data', $rating)";
    $success = mysqli_query($conn, $sql);
    if ($success) {
        $message = "Feedback adăugat cu succes.";
    } else {
        $message = "Eroare la adăugarea feedback-ului: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Adaugă Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?>" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
  <a href="add-feedback.html" class="btn btn-primary">Adaugă alt feedback</a>
  <a href="index.html" class="btn btn-secondary ms-2">Înapoi la dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
