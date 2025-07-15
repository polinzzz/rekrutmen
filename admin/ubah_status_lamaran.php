<?php
include 'koneksi.php';
session_start();

// Verifikasi parameter 'id' dan 'status' di URL
if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Permintaan tidak valid.");
}

$id = (int) $_GET['id']; // Mengonversi ID ke integer untuk keamanan
$status = $_GET['status']; // Status diterima dari parameter URL

// Daftar status yang diizinkan untuk perubahan
$allowed_statuses = [
    'Menunggu',
    'Lolos Administrasi',
    'Ujian',
    'Lolos_Ujian',
    'Gagal_Ujian',
    'Interview',
    'Diterima',
    'Ditolak'
];

// Memeriksa apakah status yang diterima valid
if (!in_array($status, $allowed_statuses)) {
    die("Status tidak valid. Status yang dikirim: $status");
}

// Gunakan prepared statement untuk memastikan keamanan query
$stmt = mysqli_prepare($conn, "UPDATE pelamar SET status_lamaran = ? WHERE id = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['pesan'] = "Status lamaran berhasil diubah menjadi <strong>$status</strong>.";
    } else {
        $_SESSION['pesan'] = "Gagal mengubah status lamaran: " . mysqli_error($conn);
    }

    header("Location: admin_dashboard.php");
    exit();
} else {
    $_SESSION['pesan'] = "Terjadi kesalahan saat menyiapkan query: " . mysqli_error($conn);
    header("Location: admin_dashboard.php");
    exit();
}
?>
