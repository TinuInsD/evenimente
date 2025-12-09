<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Bine ai venit - Evenimente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href=""><i class="bi bi-calendar-event"></i> Evenimente</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="">Acasă</a></li>
        <li class="nav-item"><a class="nav-link" href="despre-noi-nelogat.html">Despre noi</a></li>
        <li class="nav-item"><a class="nav-link" href="faq-nelogat.html">FAQ</a></li>
      </ul>
      <div class="d-flex">
        <a href="login.html" class="btn btn-outline-light me-2">Login</a>
        <a href="register.html" class="btn btn-light">Înregistrare</a>
      </div>
    </div>
  </div>
</nav>

<section class="hero-section text-white text-center d-flex align-items-center" style="background: url('images/index1 html.png') center center / cover no-repeat; height: 70vh;">
  <div class="container">
    <div class="bg-dark bg-opacity-50 p-5 rounded">
      <h1 class="display-5 fw-bold">Bine ați venit pe platforma noastră!</h1>
      <p class="lead">Organizează, descoperă și participă la evenimente într-un singur loc.</p>
      <a href="contact-nelogat.html" class="btn btn-lg btn-primary mt-3">Contactează-ne</a>
    </div>
  </div>
</section>

<section class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center mb-5">Ce poți face pe platforma noastră?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 border-primary shadow-sm">
          <div class="card-body text-center">
            <i class="bi bi-calendar-check display-4 text-primary"></i>
            <h5 class="card-title mt-3">Descoperă Evenimente</h5>
            <p class="card-text">Explorează o varietate de evenimente publice din toată țara.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-success shadow-sm">
          <div class="card-body text-center">
            <i class="bi bi-ticket display-4 text-success"></i>
            <h5 class="card-title mt-3">Rezervă bilete</h5>
            <p class="card-text">Autentifică-te pentru a cumpăra bilete la evenimentele tale preferate.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-warning shadow-sm">
          <div class="card-body text-center">
            <i class="bi bi-chat-dots display-4 text-warning"></i>
            <h5 class="card-title mt-3">Lasă Feedback</h5>
            <p class="card-text">După ce participi, poți lăsa recenzii și comentarii organizatorilor.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-5">
      <a href="login.html" class="btn btn-primary btn-lg me-2">Login</a>
      <a href="register.html" class="btn btn-outline-primary btn-lg">Creează cont</a>
    </div>
  </div>
</section>

<footer class="bg-dark text-white text-center py-4">
  <div class="container">
    <p class="mb-0">&copy; 2025 Evenimente. Toate drepturile rezervate.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
