<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'evenimente';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}
?>
