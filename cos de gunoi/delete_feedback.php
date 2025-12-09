<?php
session_start();
include 'db.php';

if (!isset($_SESSION['este_admin']) || $_SESSION['este_admin'] !== true) {
  die("Acces interzis.");
}

$id = (int) $_POST['id'];
mysqli_query($conn, "DELETE FROM feedback WHERE id = $id");

header("Location: admin_feedback.php");
exit;
?>
