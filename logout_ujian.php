<?php
session_start();
session_destroy();
header("Location: login_ujian_pelamar.php"); // Ganti dengan login_ujian_pelamar.php jika itu halaman login Anda
exit;
?>