<?php
session_start();
include 'verifica_drepturi.php';
include 'navbar.php';

if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    die("Acces interzis. Doar administratorii pot vedea această pagină.");
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Panou Administrator - Evenimente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <section class="hero-section text-white text-center d-flex align-items-center" style="background: url('images/pc mentenanta.jpg') center center / cover no-repeat; height: 60vh;">
    <div class="container">
      <div class="bg-dark bg-opacity-50 p-5 rounded">
        <h1 class="display-5 fw-bold">Panou de Administrare</h1>
        <p class="lead">Gestionează evenimentele, utilizatorii și feedback-urile cu ușurință.</p>
      </div>
    </div>
  </section>

  <section class="py-5 bg-white">   <!-- functionalitati admin -->
    <div class="container">
      <h2 class="mb-4 text-center">Instrumente Administrative</h2>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-primary shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-primary"><i class="bi bi-plus-circle"></i> Adaugă Eveniment</h5>
              <p class="card-text">Adaugă un eveniment nou în sistem.</p>
              <a href="add_event_form.php" class="btn btn-outline-primary">Formular</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-success shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-success"><i class="bi bi-calendar3"></i> Vizualizează Evenimente</h5>
              <p class="card-text">Șterge sau Editează Lista tuturor evenimentelor înregistrate.</p>
              <a href="view_events_admin.php" class="btn btn-outline-success">Evenimente</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-warning shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-warning"><i class="bi bi-people"></i> Vizualizează Utilizatori</h5>
              <p class="card-text">Gestionează utilizatorii platformei.</p>
              <a href="view_users.php" class="btn btn-outline-warning">Utilizatori</a>
            </div>
          </div>
        </div>          
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-primary shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-primary"><i class="bi bi-people"></i> Administrare Bilete</h5>
              <p class="card-text">Gestionează biletele.</p>
              <a href="manage_tickets_admin.php" class="btn btn-outline-primary">Bilete</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-success shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-success"><i class="bi bi-calendar3"></i> Vizualizare Feedback-uri</h5>
              <p class="card-text">Lista tuturor Feedback-urilor înregistrate.</p>
              <a href="view_feedback.php" class="btn btn-outline-success">Feedback</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-danger shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-danger"><i class="bi bi-calendar3"></i> Vezi mesajele</h5>
              <p class="card-text">Mesajele trimise de către utilizatori.</p>
              <a href="view_messages.php" class="btn btn-outline-danger">Mesaje</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-danger shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-danger"><i class="bi bi-box-arrow-right"></i> Deconectare</h5>
              <p class="card-text">Ieși din panoul de administrare.</p>
              <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-4">
    <div class="container">
      <p class="mb-0">&copy; 2025 Panou Admin Evenimente. Toate drepturile rezervate.</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
