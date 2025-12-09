<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

function are_drept_rol($fisier) {
    global $conn;
    if (!isset($_SESSION['id_rol'])) {
        return false;
    }
    $id_rol = $_SESSION['id_rol'];

    $sql = "
        SELECT p.fisier
        FROM drepturi_rol dr
        JOIN pagini p ON dr.id_pagina = p.id
        WHERE dr.id_rol = ? AND p.fisier = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_rol, $fisier);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

$pagina_curenta = basename($_SERVER['PHP_SELF']);
if (!are_drept_rol($pagina_curenta)) {
    echo "<div class='alert alert-danger text-center mt-5'>⛔ Acces interzis. Nu ai drepturi pentru pagina: <strong>$pagina_curenta</strong></div>";
    exit;
}
?>
