<?php
include 'db.php';
include 'navbar_user.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT e.*, c.nume AS categorie_nume 
          FROM evenimente e
          LEFT JOIN categorii_evenimente c ON e.categorie = c.id
          WHERE e.id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Evenimentul nu a fost găsit.";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Partajează Evenimentul</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .share-buttons a {
      margin: 0.5rem;
      padding: 0.75rem 1.2rem;
      border-radius: 12px;
      text-decoration: none;
      color: white;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 500;
    }
    .share-instagram { background-color: #E1306C; }
    .share-whatsapp  { background-color: #25D366; }
    .share-facebook  { background-color: #3b5998; }
    .share-twitter   { background-color: #1DA1F2; }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold"><i class="bi bi-share-fill"></i> Partajează Evenimentul</h2>
    <p class="text-muted">Distribuie acest eveniment cu prietenii tăi</p>
  </div>

  <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 600px;">
    <div class="card-body">
      <h4 class="card-title"><?= htmlspecialchars($row['nume']) ?></h4>
      <p><strong>Locație:</strong> <?= htmlspecialchars($row['locatie']) ?></p>
      <p><strong>Data:</strong> <?= htmlspecialchars($row['data']) ?></p>
      <p><strong>Categorie:</strong> <?= htmlspecialchars($row['categorie_nume']) ?></p>
      <p><?= nl2br(htmlspecialchars($row['descriere'])) ?></p>

      <hr>
      <div class="text-center share-buttons">
        <a href="https://www.instagram.com/" class="share-instagram"><i class="bi bi-instagram"></i> Share on Instagram</a>
        <a href="https://wa.me/?text=Vino%20la%20evenimentul%20<?= urlencode($row['nume']) ?>%20-%20<?= urlencode('http://localhost/evenimente/event_details.php?id=' . $row['id']) ?>" class="share-whatsapp" target="_blank">
          <i class="bi bi-whatsapp"></i> Share on WhatsApp
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://localhost/evenimente/event_details.php?id=' . $row['id']) ?>" class="share-facebook" target="_blank">
          <i class="bi bi-facebook"></i> Share on Facebook
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://localhost/evenimente/event_details.php?id=' . $row['id']) ?>&text=<?= urlencode($row['nume']) ?>" class="share-twitter" target="_blank">
          <i class="bi bi-twitter"></i> Share on Twitter
        </a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
