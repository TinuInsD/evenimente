<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-calendar-event"></i> Evenimente - Acasă</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="contact-nelogat.html">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="faq-nelogat.html">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="despre-noi-nelogat.html">Despre noi</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $parola = $_POST['parola'];
    $stmt = $conn->prepare("SELECT id, username, parola, id_rol FROM utilizatori WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($parola, $row['parola'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['id_rol'] = $row['id_rol'];

            if ($row['id_rol'] == 1) {
                header("Location: index_admin.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            echo "Parolă incorectă.";
        }
    } else {
        echo "Utilizatorul nu a fost găsit.";
    }

    $stmt->close();
    $conn->close();
}
