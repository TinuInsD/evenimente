<?php include 'user_protectie.php'; 
include 'navbar_user.php';
include 'db.php';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Evenimente - Acasă</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<section class="hero-section text-white text-center d-flex align-items-center" style="background: url('images/index1 html.png') center center / cover no-repeat; height: 70vh;">
  <div class="container">
    <div class="bg-dark bg-opacity-50 p-5 rounded">
      <h1 class="display-5 fw-bold">Bine ați venit pe platforma de Evenimente</h1>
      <p class="lead">Descoperiți, organizați și participați la cele mai tari evenimente!</p>
      <a href="events-details-public.php" class="btn btn-lg btn-primary mt-3">Cauți un eveniment aproape de tine?</a>
    </div>
  </div>
</section>

  <section class="py-5 bg-white">
    <div class="container">
      <h2 class="mb-4 text-center">Afla Care Sunt Cele Mai Noi Evenimentele Disponibile</h2>
            <div class="row g-4">
      </div>
    </div>
  </section>

  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="mb-4 text-center">Evenimente Recomandate</h2>
      <div class="row g-4">

  <style>
    .card {
      height: 100%;
      background-color: lightgray;

    }
    .card-body {
      flex-grow: 1;
    }
    .card-footer {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 1rem;
      border-top: none;
      background-color: transparent;
    }
  </style>
      
      <?php
        include 'db.php';

        $query = "SELECT * FROM evenimente ORDER BY data DESC LIMIT 3";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
          if (!empty($row['nume']) && !empty($row['descriere'])) {
            echo '<div class="col-md-4">';
            echo '<div class="card h-100 shadow-sm">';
            echo '<img src="images/index1 php.jpg" class="card-img-top" alt="Imagine Eveniment" onerror="this.src=\'images/fallback.jpg\'">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['nume']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($row['descriere']) . '</p>';
            echo '<a href="event_details.php?id=' . urlencode($row['id']) . '" class="btn btn-outline-primary">Vezi Detalii</a>';
            echo '</div></div></div>';
          }
        }
        mysqli_close($conn);
      ?>
    </div>
      </div>
      <div class="text-center mt-4">
        <a href="view_events.php" class="btn btn-primary me-2">Toate Evenimentele</a>
      </div>
    </div>
  </section>
  <footer class="bg-dark text-white text-center py-4">
    <div class="container">
      <p class="mb-0">&copy; 2025 Evenimente. Toate drepturile rezervate.</p>
    </div>
    <div class="text-center mt-3">
        <a href="leave_feedback.php" class="btn btn-light">Lasă Feedback</a>
      </div>
    </div>
  </section>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
