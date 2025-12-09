<?php 
include 'admin_protectie.php'; 
include 'navbar.php';
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM categorii_evenimente");

if (!$result) {
    die("Eroare la interogare categorii: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Adaugă Eveniment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Formular -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Completează Detaliile Evenimentului</h4>
        </div>
        <div class="card-body">
          <form action="add_event.php" method="POST" enctype="multipart/form-data">

  <style>
    body {
      background-image: url('images/imagine evenimente admin.webp');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      min-height: 100vh;
    }
  </style>

            <div class="mb-3">
              <label for="title" class="form-label">Titlul Evenimentului</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descriere</label>
              <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
              <label for="date" class="form-label">Data</label>
              <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="mb-3">
              <label for="time" class="form-label">Ora</label>
              <input type="time" class="form-control" id="time" name="time">
            </div>

            <div class="mb-3">
              <label for="location" class="form-label">Locația</label>
              <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <div class="mb-3">
              <label for="categorie_id" class="form-label">Categorie</label>
              <select class="form-select" id="categorie_id" name="categorie_id" required>
                <option selected disabled>Alege categoria</option>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nume']) ?></option>
                
                  <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Vizibilitate</label>
              <div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="visibility" value="public" checked>
                  <label class="form-check-label">Public</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="visibility" value="private">
                  <label class="form-check-label">Privat</label>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">Imagine Eveniment</label>
                <input class="form-control" type="file" id="image" name="image" accept="image/*">
              </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-save"></i> Salvează Evenimentul
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
