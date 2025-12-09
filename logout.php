<?php
session_start();
session_unset();    // sterge toate variabilele de sesiune
session_destroy();  // distruge sesiunea curenta

// redirect catre pagina principala
header("Location: login.html");
exit;
?>
