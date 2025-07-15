<?php
include 'koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: data_pelamar.php");
    exit;
}

$id = $_GET['id'];

// Hapus semua data terkait terlebih dahulu
mysqli_query($conn, "DELETE FROM pendidikan WHERE pelamar_id = $id");
mysqli_query($conn, "DELETE FROM pengalaman_kerja WHERE pelamar_id = $id");
mysqli_query($conn, "DELETE FROM dokumen_pendukung WHERE pelamar_id = $id");

// Baru kemudian hapus dari tabel pelamar
$hapus = mysqli_query($conn, "DELETE FROM pelamar WHERE id = $id");

if ($hapus) {
    header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php");
    exit;
} else {
    echo "Gagal menghapus data pelamar.";
}
?>
