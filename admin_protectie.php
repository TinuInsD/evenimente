<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['id_rol'] != 1) {
  die("Acces interzis. Această pagină este destinată doar administratorilor.");
}
?>

