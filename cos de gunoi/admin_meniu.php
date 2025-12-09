<?php
session_start();
include 'verifica_drepturi.php';
include 'db.php'; // conexiunea la baza de date
include 'navbar.php';

if (!are_drept(basename(__FILE__))) {
    echo "<div class='alert alert-danger text-center'>Nu aveți dreptul de a accesa această pagină.</div>";
    exit;
}

// Adăugare pagină nouă
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_pagina'])) {
    $nume = $_POST['nume'];
    $fisier = $_POST['fisier'];
    $afisat = isset($_POST['afisat']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO pagini (nume, fisier, afisat) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nume, $fisier, $afisat);
    $stmt->execute();
    header("Location: admin_meniu.php");
    exit;
}

// Ștergere pagină
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM pagini WHERE id = $id");
    $conn->query("DELETE FROM drepturi WHERE id_pagina = $id");
    header("Location: admin_meniu.php");
    exit;
}

$pagini = $conn->query("SELECT * FROM pagini ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Admin Meniu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Administrare Meniu</h2>

    <form method="POST" class="mb-5">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Nume pagină</label>
                <input type="text" name="nume" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fișier (ex: pagina.php)</label>
                <input type="text" name="fisier" class="form-control" required>
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input type="checkbox" name="afisat" class="form-check-input" id="afisat">
                    <label class="form-check-label" for="afisat">Afișat în navbar</label>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add_pagina" class="btn btn-primary">Adaugă</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Nume</th>
            <th>Fișier</th>
            <th>Afișat</th>
            <th>Acțiuni</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $pagini->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nume']) ?></td>
                <td><?= htmlspecialchars($row['fisier']) ?></td>
                <td><?= $row['afisat'] ? 'DA' : 'NU' ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Sigur vrei să ștergi această pagină?')">Șterge</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
