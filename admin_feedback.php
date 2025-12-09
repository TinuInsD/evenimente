<?php
session_start();
include 'db.php';

// verificare daca e admin
if (!isset($_SESSION['este_admin']) || $_SESSION['este_admin'] !== true) {
  die("Acces interzis.");
}

$feedbackuri = mysqli_query($conn, "
  SELECT f.*, u.username, e.nume AS eveniment 
  FROM feedback f
  JOIN utilizatori u ON f.user_id = u.id
  JOIN evenimente e ON f.eveniment_id = e.id
  ORDER BY f.data_feedback DESC
");
?>

<h2>Toate feedback-urile</h2>

<table border="1" cellpadding="10">
  <tr>
    <th>Eveniment</th>
    <th>User</th>
    <th>Rating</th>
    <th>Mesaj</th>
    <th>Data</th>
    <th>Acțiune</th>
  </tr>
  <?php while ($fb = mysqli_fetch_assoc($feedbackuri)): ?>
    <tr>
      <td><?= htmlspecialchars($fb['eveniment']) ?></td>
      <td><?= htmlspecialchars($fb['username']) ?></td>
      <td><?= $fb['rating'] ?> / 5</td>
      <td><?= nl2br(htmlspecialchars($fb['mesaj'])) ?></td>
      <td><?= $fb['data_feedback'] ?></td>
      <td>
        <form method="POST" action="delete_feedback.php" onsubmit="return confirm('Ești sigur?');">
          <input type="hidden" name="id" value="<?= $fb['id'] ?>">
          <button type="submit">Șterge</button>
        </form>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
