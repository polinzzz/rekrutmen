<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

// Gunakan prepared statement untuk keamanan
$stmt = mysqli_prepare($conn, "DELETE FROM lowongan WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    // Cek apakah ini dipanggil via AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo "sukses";
    } else {
        header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php");
    }
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
