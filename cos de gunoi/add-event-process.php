<?php
include 'db.php';

$nume = $_POST['nume'];
$data = $_POST['data'];
$locatie = $_POST['locatie'];
$organizator = $_POST['organizator'];
$descriere = $_POST['descriere'];

$sql = "INSERT INTO evenimente (nume, data, locatie, organizator, descriere)
        VALUES ('$nume', '$data', '$locatie', '$organizator', '$descriere')";

if (mysqli_query($conn, $sql)) {
  echo "Eveniment adaugat cu succes. <a href='view-events.php'>Vezi Evenimente</a>";
} else {
  echo "Eroare: " . mysqli_error($conn);
}
?>
