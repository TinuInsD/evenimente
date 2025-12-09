<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM evenimente");

echo "<div class='container mt-4'><h2>Lista Evenimente</h2><table class='table table-bordered'>";
echo "<tr><th>Nume</th><th>Data</th><th>Locatie</th><th>Organizator</th><th>Descriere</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>
    <td>{$row['nume']}</td>
    <td>{$row['data']}</td>
    <td>{$row['locatie']}</td>
    <td>{$row['organizator']}</td>
    <td>{$row['descriere']}</td>
  </tr>";
}
echo "</table></div>";
?>
