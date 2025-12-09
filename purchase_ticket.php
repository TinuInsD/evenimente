<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Trebuie să fii autentificat pentru a cumpăra bilete.");
}

$user_id = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bilet_id = (int) $_POST['bilet_id'];
  $eveniment_id = (int) $_POST['eveniment_id'];
  $cantitate = (int) $_POST['cantitate'];

  // Verificăm dacă biletul există și dacă are stoc suficient
  $check = mysqli_query($conn, "SELECT * FROM bilete WHERE id = $bilet_id AND eveniment_id = $eveniment_id");
  $bilet = mysqli_fetch_assoc($check);

  if (!$bilet) {
    die("Bilet inexistent.");
  }

  if ($cantitate <= 0 || $cantitate > $bilet['stoc']) {
    die("Cantitate invalidă sau stoc insuficient.");
  }

  $pret_total = $bilet['pret'] * $cantitate;

  // Verificăm fondurile utilizatorului
  $user_fonduri_res = mysqli_query($conn, "SELECT fonduri FROM utilizatori WHERE id = $user_id");
  $user_fonduri = mysqli_fetch_assoc($user_fonduri_res)['fonduri'];

  if ($user_fonduri < $pret_total) {
    die("Fonduri insuficiente pentru această achiziție.");
  }

  // Începem tranzacția (opțional, dar recomandat)
  mysqli_begin_transaction($conn);

  try {
    // Scădem stocul
    $nou_stoc = $bilet['stoc'] - $cantitate;
    $update_stoc = mysqli_query($conn, "UPDATE bilete SET stoc = $nou_stoc WHERE id = $bilet_id");
    if (!$update_stoc) throw new Exception("Eroare la actualizarea stocului.");

    // Scădem fondurile utilizatorului
    $update_fonduri = mysqli_query($conn, "UPDATE utilizatori SET fonduri = fonduri - $pret_total WHERE id = $user_id");
    if (!$update_fonduri) throw new Exception("Eroare la actualizarea fondurilor.");

    // Salvăm achiziția cu user_id
    $insert_cumparare = mysqli_query($conn, "
      INSERT INTO bilete_cumparate (user_id, bilet_id, eveniment_id, cantitate, data_achizitiei)
      VALUES ($user_id, $bilet_id, $eveniment_id, $cantitate, NOW())
    ");
    if (!$insert_cumparare) throw new Exception("Eroare la salvarea achiziției.");

    mysqli_commit($conn);

    header("Location: event_details.php?id=$eveniment_id&success=1");
    exit;

  } catch (Exception $e) {
    mysqli_rollback($conn);
    die("A apărut o eroare: " . $e->getMessage());
  }
} else {
  echo "Acces nepermis.";
}
?>
