<?php
include 'db.php';

$nume = $_POST['nume_utilizator'];
$email = $_POST['email'];
$mesaj = $_POST['mesaj'];
$eveniment_id = $_POST['eveniment_id'];

$sql = "INSERT INTO feedback (nume_utilizator, email, mesaj, eveniment_id)
        VALUES ('$nume', '$email', '$mesaj', $eveniment_id)";

if (mysqli_query($conn, $sql)) {
  echo "Feedback trimis cu succes. <a href='view-feedback.php'>Vezi Feedback</a>";
} else {
  echo "Eroare: " . mysqli_error($conn);
}
?>
