<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "DELETE FROM pengumuman WHERE id = $id");

    if ($query) {
        $pesan = "✅ Pengumuman berhasil dihapus.";
    } else {
        $pesan = "❌ Gagal menghapus pengumuman.";
    }

    header("Location: admin_dashboard.php?pesan=" . urlencode($pesan));
    exit;
} else {
    header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php");
    exit;
}
