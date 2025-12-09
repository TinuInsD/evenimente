<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  die("Trebuie să fii autentificat pentru a trimite feedback.");
}

$user_id = (int) $_SESSION['user_id'];
$eveniment_id = (int) $_POST['eveniment_id'];
$rating = (int) $_POST['rating'];
$mesaj = mysqli_real_escape_string($conn, $_POST['mesaj']);

// Verificare dacă a participat
$verifica = mysqli_query($conn, "SELECT * FROM bilete_cumparate WHERE user_id = $user_id AND eveniment_id = $eveniment_id");
if (mysqli_num_rows($verifica) == 0) {
  die("Nu poți lăsa feedback la un eveniment la care nu ai participat.");
}

// Salvează feedback-ul
$insert = mysqli_query($conn, "
  INSERT INTO feedback (user_id, eveniment_id, rating, mesaj)
  VALUES ($user_id, $eveniment_id, $rating, '$mesaj')
");

if ($insert) {
  header("Location: event_details.php?id=$eveniment_id&feedback=1");
} else {
  echo "Eroare la salvare feedback.";
}
?>
