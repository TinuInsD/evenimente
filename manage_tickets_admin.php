<?php
include 'admin_protectie.php';
include 'db.php';
include 'navbar.php';

if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
  die("Acces interzis. Doar administratorii pot vedea această pagină.");
}

if (isset($_GET['delete'])) {
  $ticket_id = (int)$_GET['delete'];
  mysqli_query($conn, "DELETE FROM bilete WHERE id = $ticket_id");
  header("Location: manage_tickets_admin.php?deleted=1");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['adauga'])) {
  $eveniment_id = $_POST['eveniment_id'];
  $pret = $_POST['pret'];
  $stoc = $_POST['stoc'];

  mysqli_query($conn, "
  INSERT INTO bilete (eveniment_id, pret, stoc, data_adaugare)
  VALUES ('$eveniment_id', '$pret', '$stoc', NOW())
");

  header("Location: manage_tickets_admin.php?added=1");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['modifica'])) {
  $id = $_POST['id'];
  $eveniment_id = $_POST['eveniment_id'];
  $pret = $_POST['pret'];
  $stoc = $_POST['stoc'];

  mysqli_query($conn, "
    UPDATE bilete SET eveniment_id='$eveniment_id', pret='$pret', stoc='$stoc'
    WHERE id='$id'
  ");
  header("Location: manage_tickets_admin.php?updated=1");
  exit;
}

$bilet_edit = null;
if (isset($_GET['edit'])) {
  $edit_id = (int)$_GET['edit'];
  $res = mysqli_query($conn, "SELECT * FROM bilete WHERE id = $edit_id");
  $bilet_edit = mysqli_fetch_assoc($res);
}

$evenimente = mysqli_query($conn, "SELECT id, nume FROM evenimente ORDER BY data DESC");

// Biletele existente
$bilete = mysqli_query($conn, " 
  SELECT b.*, e.nume AS nume_eveniment  
  FROM bilete b 
  JOIN evenimente e ON b.eveniment_id = e.id
  ORDER BY b.id DESC
");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Administrare Bilete</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="mt-5">
  <h1 class="mb-5">🎟️ Administrare Bilete</h1>

  <?php
   if (isset($_GET['added'])): ?>
    <div class="alert alert-success">Bilet adăugat cu succes!</div>
  <?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert alert-warning">Bilet șters!</div>
  <?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-info">Bilet modificat cu succes!</div>
  <?php endif; ?>

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

<form method="POST" class="row g-3 mb-4 border p-3 bg-light">
    <input type="hidden" name="id" value="<?= $bilet_edit['id'] ?? '' ?>">
    <div class="col-md-4">
      <label class="form-label">Eveniment</label>
      <select name="eveniment_id" class="form-select" required>
        <option value="">Alege un eveniment</option>
        <?php
         while ($e = mysqli_fetch_assoc($evenimente)): ?>
          <option value="<?= $e['id'] ?>" 
            <?= ($bilet_edit && $bilet_edit['eveniment_id'] == $e['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($e['nume']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Preț (RON)</label>
      <input type="number" name="pret" class="form-control" step="0.01" required
             value="<?= $bilet_edit['pret'] ?? '' ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Stoc bilete</label>
      <input type="number" name="stoc" class="form-control" required
             value="<?= $bilet_edit['stoc'] ?? '' ?>">
    </div>
    <div class="col-md-2 d-grid align-self-end">
      <button type="submit" name="<?= $bilet_edit ? 'modifica' : 'adauga' ?>" 
              class="btn btn-<?= $bilet_edit ? 'info' : 'primary' ?>">
        <?= $bilet_edit ? 'Salvează' : 'Adaugă' ?>
      </button>
    </div>
  </form>

  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Eveniment</th>
        <th>Preț</th>
        <th>Stoc</th>
        <th>Adăugat</th>
        <th>Modificat</th>
        <th>Acțiuni</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($b = mysqli_fetch_assoc($bilete)): ?>
        <tr>
          <td><?= $b['id'] ?></td>
          <td><?= htmlspecialchars($b['nume_eveniment']) ?></td>
          <td><?= number_format($b['pret'], 2) ?> RON</td>
          <td><?= $b['stoc'] ?></td>
          <td><?= date('Y-m-d H:i', strtotime($b['data_adaugare'])) ?></td>
          <td><?= date('Y-m-d H:i', strtotime($b['data_modificare'])) ?></td>
          <td>
            <a href="manage_tickets_admin.php?edit=<?= $b['id'] ?>" class="btn btn-sm btn-info">Editează</a>
            <a href="manage_tickets_admin.php?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Sigur vrei să ștergi acest bilet?')">Șterge</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="index_admin.php" class="btn btn-secondary mt-4">🏠 Înapoi Acasă</a>
</div>
</body>
</html>
