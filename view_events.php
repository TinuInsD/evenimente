<?php include 'user_protectie.php'; ?>
<?php
include 'db.php';
include 'navbar_user.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "
  SELECT e.*, c.nume AS categorie_nume 
  FROM evenimente e
  LEFT JOIN categorii_evenimente c ON e.categorie = c.id
";

if (!empty($search)) {
  $query .= " WHERE e.nume LIKE '%$search%' OR e.locatie LIKE '%$search%' OR e.descriere LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Evenimente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-image: url('images/evenimente user.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      min-height: 100vh;
    }
    .overlay {
      background-color: rgba(255, 255, 255, 0.85); /* ușor alb transparent pentru lizibilitate */
      min-height: 100vh;
      padding: 2rem 0;
    }
    .card {
      height: 100%;
      background-color: lightgray; /* ușor alb transparent pentru lizibilitate */

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
  <style>
    body {
      background-color: #f8f9fa;
    }

    .navbar {
      margin-bottom: 40px;
    }

    .search-form {
      max-width: 500px;
      margin: 0 auto 30px;
    }

    .card-event {
      border: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(0,0,0,0.05);
    }

    .card-event:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .card-title {
      font-size: 1.3rem;
      font-weight: 600;
    }

    .card-text {
      font-size: 0.95rem;
    }

    .btn-details {
      margin-top: auto;
    }
  </style>
</head>
<body>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="despre-noi.html">Despre noi</a></li>
      </ul>

      <form class="d-flex" method="GET" action="view_events.php">
        <input class="form-control me-2" type="search" name="search" placeholder="Caută evenimente..." aria-label="Search" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </div>
</nav>

<div class="container">
<h2 class="mb-4 text-center text-light gray"><i class="bi bi-stars"></i> Evenimente disponibile</h2>
  <div class="search-form mb-4">
    <form class="d-flex justify-content-center" method="GET" action="view_events.php">
      <input class="form-control me-2 w-50" type="search" name="search" placeholder="Caută evenimente..." aria-label="Search" value="<?= htmlspecialchars($search) ?>">
      <button class="btn btn-outline text-white" type="submit"><i class="bi bi-search"></i> Caută</button>
    </form>
  </div>

  <?php if ($search): ?>
    <p class="text-white text-center">Rezultate pentru <strong><?= htmlspecialchars($search) ?></strong>:</p>
    <?php endif; ?>
  <div class="row">
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0 rounded-4">
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="card-title mb-2"><?= htmlspecialchars($row['nume']) ?></h5>
              <p class="card-text"><strong>Locație:</strong> <?= htmlspecialchars($row['locatie']) ?></p>
              <p class="card-text"><strong>Data:</strong> <?= $row['data'] ?></p>
              <p class="card-text"><strong>Categorie:</strong> <?= htmlspecialchars($row['categorie_nume']) ?></p>
              <p class="card-text text-muted small"><?= substr(htmlspecialchars($row['descriere']), 0, 100) ?>...</p>
            </div>
            <div class="d-grid gap-2 mt-3">
              <a href="event_details.php?id=<?= $row['id'] ?>" class="btn btn-primary">
                <i class="bi bi-info-circle"></i> Vezi detalii
              </a>
              <a href="leave_feedback.php?id=<?= $row['id'] ?>" class="btn btn-outline-success">
                <i class="bi bi-ticket-perforated"></i> Ai participat? Lasă feedback!
              </a>
              <a href="share_event.php?id=<?= $row['id'] ?>" class="btn btn-outline-secondary">
                <i class="bi bi-share-fill"></i> Partajează
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="col-12">
      <div class="alert alert-warning">Nu s-au găsit evenimente pentru căutarea introdusă.</div>
    </div>
  <?php endif; ?>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
  <div class="container">
    <p class="mb-0">&copy; <?= date('Y') ?> Evenimente. Toate drepturile rezervate.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
