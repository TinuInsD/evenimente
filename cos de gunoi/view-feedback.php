<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM feedback");

echo "<div class='container mt-4'><h2>Lista Feedback</h2><table class='table table-striped'>";
echo "<tr><th>Nume</th><th>Email</th><th>Mesaj</th><th>Eveniment ID</th><th>Data</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>
    <td>{$row['nume_utilizator']}</td>
    <td>{$row['email']}</td>
    <td>{$row['mesaj']}</td>
    <td>{$row['eveniment_id']}</td>
    <td>{$row['data_submit']}</td>
  </tr>";
}
echo "</table></div>";
?>
