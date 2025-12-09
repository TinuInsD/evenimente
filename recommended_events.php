<?php
include 'db.php';

$sql = "SELECT * FROM evenimente WHERE organizator = 'admin' ORDER BY data DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
  $events[] = $row;
}

header('Content-Type: application/json');
echo json_encode($events);
?>
