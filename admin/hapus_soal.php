<?php
include 'koneksi.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM soal_ujian WHERE id = '$id'");
header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php");
