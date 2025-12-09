<?php
session_start();
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
  header("Location: view_messages.php");
  exit;
}

include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = intval($_GET['id']);

  $sql = "DELETE FROM mesaje_contact WHERE id = $id LIMIT 1";
  mysqli_query($conn, $sql);
}

header("Location: view_messages.php");
exit;
