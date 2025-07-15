<?php
$host = "localhost"; // biasanya localhost
$user = "root"; // username database
$pass = ""; // password database
$db   = "everbrightdb"; // ganti dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
