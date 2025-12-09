<?php include 'user_protectie.php'; ?>

<?php
include 'db.php';
include 'navbar_user.php';

if (!isset($_GET['id'])) {
  echo "Eveniment inexistent.";
  exit;
}

$event_id = (int) $_GET['id'];
$event_query = mysqli_query($conn, "
  SELECT e.*, c.nume AS categorie_nume
  FROM evenimente e
  LEFT JOIN categorii_evenimente c ON e.categorie = c.id
  WHERE e.id = $event_id
");
$event = mysqli_fetch_assoc($event_query);
if (!$event) {
  echo "Evenimentul nu a fost găsit.";
  exit;
}

$tickets_query = mysqli_query($conn, "
  SELECT * FROM bilete WHERE eveniment_id = $event_id
");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($event['nume']) ?> - Detalii</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .hero {
      background: linear-gradient(to right, #007bff, #00c6ff);
      color: white;
      padding: 60px 30px;
      border-radius: 12px;
    }
    .ticket-card {
      transition: transform 0.2s;
    }
    .ticket-card:hover {
      transform: scale(1.03);
    }
  </style>
</head>
<body>

<div class="container mt-5">
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success">✅ Bilet cumpărat cu succes!</div>
<?php endif; ?>

<?php
  $bgImage = !empty($event['imagine']) ? htmlspecialchars($event['imagine']) : 'images/fallback.jpg';
?>
<section class="hero-section text-white text-center d-flex align-items-center" style="background: url('<?= $bgImage ?>') center center / cover no-repeat; height: 70vh; width: 100%;">
  <div class="w-100">
    <div class="bg-dark bg-opacity-50 p-4 rounded">
      <h2 class="display-5 fw-bold"><?= htmlspecialchars($event['nume']) ?></h2>
      <p><i class="bi bi-geo-alt"></i> <strong>Locație:</strong> <?= htmlspecialchars($event['locatie']) ?></p>
      <p><i class="bi bi-calendar"></i> <strong>Data:</strong> <?= $event['data'] ?> &nbsp; <i class="bi bi-clock"></i> <?= $event['ora'] ?></p>
      <p><i class="bi bi-person"></i> <strong>Organizator:</strong> <?= htmlspecialchars($event['organizator']) ?></p>
      <p><i class="bi bi-tags"></i> <strong>Categorie:</strong> <?= htmlspecialchars($event['categorie_nume']) ?></p>
      <p class="mt-4"><?= nl2br(htmlspecialchars($event['descriere'])) ?></p>
    </div>
  </div>
</section>

  <h3 class="mb-5">Bilete disponibile</h4>
  <div class="row">
    <?php while ($ticket = mysqli_fetch_assoc($tickets_query)): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow ticket-card h-100">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($ticket['tip']) ?></h5>
            <p class="card-text">
              <strong>Preț:</strong> <?= number_format($ticket['pret'], 2) ?> RON<br>
              <strong>Stoc:</strong> <?= $ticket['stoc'] ?> bilete
            </p>
            <?php if ($ticket['stoc'] > 0): ?>
              <form method="post" action="purchase_ticket.php">
                <input type="hidden" name="bilet_id" value="<?= $ticket['id'] ?>">
                <input type="hidden" name="eveniment_id" value="<?= $event_id ?>">
                <div class="input-group mb-2">
                  <input type="number" name="cantitate" min="1" max="<?= $ticket['stoc'] ?>" class="form-control" placeholder="Nr. bilete" required>
                  <button type="submit" class="btn btn-success">Cumpără</button>
                </div>
              </form>
            <?php else: ?>
              <div class="alert alert-warning mb-0">Stoc epuizat</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>