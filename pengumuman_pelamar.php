<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['pelamar'])) {
    header("Location: login.php");
    exit();
}

$email_pelamar = $_SESSION['pelamar'];
$query_pelamar = mysqli_query($conn, "SELECT * FROM pelamar WHERE email = '$email_pelamar' LIMIT 1");
$pelamar = mysqli_fetch_assoc($query_pelamar);
$nama_pelamar = $pelamar ? $pelamar['nama'] : 'Pelamar';

$result = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengumuman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand img {
            filter: drop-shadow(0 0 2px rgba(0,0,0,0.25));
        }
        .welcome-text {
            color: white;
            margin-left: 10px;
            font-weight: 600;
        }
        .judul-pengumuman {
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
            margin-bottom: 20px;
        }
        .card {
            transition: transform 0.2s ease-in-out;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: scale(1.01);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        footer {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<!-- Navbar konsisten dengan dashboard -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/logo1ABC.png" alt="Logo" style="height: 40px;" />
            <span class="welcome-text">Selamat Datang, <?= htmlspecialchars($nama_pelamar) ?>!</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard_pelamar.php"><i class="bi bi-briefcase"></i> Lowongan</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="lamaran_saya.php"><i class="bi bi-send"></i> Proses Lamaran</a></li>
                <li class="nav-item"><a class="nav-link text-white active" href="pengumuman_pelamar.php"><i class="bi bi-bell-fill"></i> Pengumuman</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="login_ujian_pelamar.php"><i class="bi bi-journal-text"></i> Ujian</a></li>
                <li class="nav-item"><a class="nav-link text-warning fw-bold" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Konten Pengumuman -->
<div class="container mt-5 mb-5">
    <div class="judul-pengumuman">
        <h3>📢 Pengumuman Terbaru</h3>
        <p class="text-muted">Berikut adalah daftar pengumuman penting untuk Anda.</p>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <strong><?= htmlspecialchars($row['judul']) ?></strong>
                    <span class="float-end text-muted"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></span>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(htmlspecialchars($row['isi'])) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center fw-semibold">Belum ada pengumuman yang tersedia.</div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> Dashboard Pelamar - PT Everbright. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
