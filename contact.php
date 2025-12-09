<?php
include 'db.php';
include 'navbar_user.php';

$este_logat = isset($_SESSION['user_id']);
$nume = '';
$email = '';

if ($este_logat) {
    $user_id = (int) $_SESSION['user_id'];
    $query = "SELECT username, email FROM utilizatori WHERE id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $nume = htmlspecialchars($user['username']);
        $email = htmlspecialchars($user['email']);
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Formular de Contact</h2>
    <form action="send_contact.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Nume:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $nume ?>" required>
      </div>

      <?php if (!$este_logat): ?>
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
      <?php else: ?>
        <input type="hidden" name="email" value="<?= $email ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label for="message" class="form-label">Mesaj:</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Trimite</button>
    </form>
  </div>

<script>  // validare javaScript
  document.getElementById("contactForm").addEventListener("submit", function(event) {
  const name = document.getElementById("name").value.trim();
  const message = document.getElementById("message").value.trim();
  const emailField = document.getElementById("email");
  const email = emailField ? emailField.value.trim() : null;
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!name || !message) {
    alert("Te rugăm să completezi toate câmpurile.");
    event.preventDefault();
    return;
  }
  if (emailField && (!email || !emailPattern.test(email))) {
    alert("Te rugăm să introduci un email valid.");
    event.preventDefault();
    return;
  }
});
</script>
</body>
</html>
