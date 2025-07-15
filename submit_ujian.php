<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['pelamar_id'])) {
    echo "<script>alert('Silakan login.'); window.location='login_pelamar.php';</script>";
    exit;
}

$pelamar_id = $_SESSION['pelamar_id'];

// Cek status lamaran
$query = mysqli_query($conn, "SELECT status_lamaran FROM pelamar WHERE id = '$pelamar_id'");
$pelamar = mysqli_fetch_assoc($query);

if (!$pelamar) {
    echo "<script>alert('Data pelamar tidak ditemukan.'); window.location='dashboard_pelamar.php';</script>";
    exit;
}

// Cek apakah sudah pernah menjawab
$cek_jawaban = mysqli_query($conn, "SELECT COUNT(*) as total FROM jawaban_ujian WHERE pelamar_id = '$pelamar_id'");
$data_jawaban = mysqli_fetch_assoc($cek_jawaban);

if ($data_jawaban['total'] > 0) {
    echo "<script>alert('Anda sudah menyelesaikan ujian dan tidak dapat mengubah jawaban.'); window.location='dashboard_pelamar.php';</script>";
    exit;
}

// Hanya proses jika ada jawaban yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['jawaban'])) {
    foreach ($_POST['jawaban'] as $soal_id => $jawaban) {
        $soal_id = intval($soal_id);
        $jawaban = mysqli_real_escape_string($conn, $jawaban);

        mysqli_query($conn, "INSERT INTO jawaban_ujian (pelamar_id, soal_id, jawaban) 
                             VALUES ('$pelamar_id', '$soal_id', '$jawaban')");
    }

    // Update status lamaran
    mysqli_query($conn, "UPDATE pelamar SET status_lamaran = 'selesai_ujian' WHERE id = '$pelamar_id'");

    echo "<script>alert('Jawaban berhasil dikirim. Terima kasih.'); window.location='dashboard_pelamar.php';</script>";
    exit;
} else {
    echo "<script>alert('Tidak ada jawaban dikirim.'); window.location='ujian.php';</script>";
    exit;
}
?>
