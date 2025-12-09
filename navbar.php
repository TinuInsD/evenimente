<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$meniuri = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "
    SELECT DISTINCT p.nume, p.fisier
    FROM drepturi d
    JOIN pagini p ON d.id_pagina = p.id
    WHERE d.id_utilizator = ? AND p.afisat = 1
    ORDER BY p.nume
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $meniuri[] = $row;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="index_admin.php">🎫 Evenimente</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php foreach ($meniuri as $item): ?>
          <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == $item['fisier']) ? 'active' : '' ?>"
               href="<?= htmlspecialchars($item['fisier']) ?>">
              <?= htmlspecialchars($item['nume']) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <ul class="navbar-nav">
      <li class="nav-item">
      
      <div class="d-flex">
        <span class="navbar-text text-white me-4">Bun venit, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </li>  
      <li class="nav-item">
          <a class="nav-link" href="my_account_admin.php">Contul Meu</a>
        </li>  
      <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
