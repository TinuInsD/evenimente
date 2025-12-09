<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT p.nume, p.fisier 
        FROM pagini p
        JOIN drepturi d ON p.id = d.id_pagina
        WHERE d.id_utilizator = ? AND p.afisat = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-calendar-event"></i> Evenimente</a>  
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Acasă</a></li>
        <?php while ($row = $result->fetch_assoc()): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= htmlspecialchars($row['fisier']) ?>">
              <?= htmlspecialchars($row['nume']) ?>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
      <ul class="navbar-nav">
      <li class="nav-item"></li>
      <div class="d-flex">
          <span class="navbar-text text-white me-4">Bun venit, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </li>  
        <li class="nav-item">
          <a class="nav-link text" href="my_account.php">Contul meu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
