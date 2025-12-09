<?php
session_start();
include 'db.php'; // conexiunea la baza de date

if (!isset($_SESSION['id_rol'])) {
  die("Acces neautorizat.");
}

// Extragem numele fișierului curent
$pagina_curenta = basename($_SERVER['PHP_SELF']);

// Obținem id-ul paginii din baza de date
$stmt = $conn->prepare("SELECT id FROM pagini WHERE fisier = ?");
$stmt->bind_param("s", $pagina_curenta);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  die("Pagina nu este înregistrată în sistem.");
}

$row = $result->fetch_assoc();
$id_pagina = $row['id'];
$id_rol = $_SESSION['id_rol'];

// Verificăm dacă rolul are acces la această pagină
$stmt2 = $conn->prepare("SELECT * FROM drepturi_rol WHERE id_rol = ? AND id_pagina = ?");
$stmt2->bind_param("ii", $id_rol, $id_pagina);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows == 0) {
  die("Acces interzis.");
}
?>
