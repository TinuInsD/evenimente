<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="welcome.php"><i class="bi bi-calendar-event"></i> Evenimente - Acasa</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="contact-nelogat.html">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="despre-noi-nelogat.html">Despre noi</a></li>
        <li class="nav-item"><a class="nav-link" href="faq-nelogat.html">FAQ</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
include 'db.php';

$mesaj = "";
$tip_alerta = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $parola = $_POST['parola']; // hash mai jos
    $tip = mysqli_real_escape_string($conn, $_POST['tip']); // 'admin' sau 'user'
    $check = mysqli_query($conn, "SELECT * FROM utilizatori WHERE username='$username' OR email='$email' LIMIT 1");
    if (mysqli_num_rows($check) > 0) {
        $mesaj = "Utilizatorul există deja. Alege alt nume.";
        $tip_alerta = "danger";
    } else {
        // Căutăm id_rol în tabela roluri după numele rolului ($tip)
        $stmt = $conn->prepare("SELECT id FROM roluri WHERE nume = ?");
        $stmt->bind_param("s", $tip);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $rol = $result->fetch_assoc();
            $id_rol = $rol['id'];
            $parolaHash = password_hash($parola, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO utilizatori (username, email, parola, id_rol) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("sssi", $username, $email, $parolaHash, $id_rol);
            if ($stmt2->execute()) {
                $id_utilizator = $conn->insert_id;

                // Inserăm drepturile în tabelul drepturi: atribuim toate paginile aferente rolului
                // Presupunem că ai o tabelă drepturi_rol(id_rol, id_pagina) care leagă rolurile de pagini
                $stmt3 = $conn->prepare("INSERT INTO drepturi (id_utilizator, id_pagina)
                                         SELECT ?, id_pagina FROM drepturi_rol WHERE id_rol = ?");
                $stmt3->bind_param("ii", $id_utilizator, $id_rol);
                $stmt3->execute();

                $mesaj = "Cont creat cu succes! Acum te poți autentifica.";
                $tip_alerta = "success";
            } else {
                $mesaj = "Eroare la înregistrare. Încearcă din nou.";
                $tip_alerta = "danger";
            }
        } else {
            $mesaj = "Rol invalid selectat.";
            $tip_alerta = "danger";
        }
    }
} else {
    $mesaj = "Acces interzis.";
    $tip_alerta = "danger";
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Înregistrare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="alert alert-<?= $tip_alerta ?>" role="alert">
      <?= htmlspecialchars($mesaj) ?>
    </div>

    <?php if ($tip_alerta === "success"): ?>
      <a href="login.html" class="btn btn-success">Autentifică-te</a>
    <?php else: ?>
      <a href="register.html" class="btn btn-outline-danger">Înapoi la înregistrare</a>
    <?php endif; ?>
  </div>
</body>
</html>
