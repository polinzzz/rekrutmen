<?php
session_start();
if (!isset($_SESSION['pelamar'])) {
    header("Location: admin/login.php");
    exit;
}

include 'koneksi.php';

$email_pelamar = $_SESSION['pelamar'];

$query = "SELECT * FROM pelamar WHERE email = '$email_pelamar' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);
$nama_pelamar = $data ? $data['nama'] : 'Pelamar';
$status = strtolower($data['status_lamaran'] ?? '');
$class_status = match($status) {
    'diterima' => 'diterima',
    'ditolak' => 'ditolak',
    default => 'belum'
};
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Lamaran Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        footer {
            background-color: #0d6efd;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
        .status {
            font-weight: bold;
        }
        .status.belum {
            color: #ffc107;
        }
        .status.diterima {
            color: #198754;
        }
        .status.ditolak {
            color: #dc3545;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        .card-title {
            font-weight: 700;
            color: #0d6efd;
        }
        .navbar-brand img {
            filter: drop-shadow(0 0 2px rgba(0,0,0,0.25));
        }
        .welcome-text {
            color: white;
            margin-left: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Navbar Sama dengan dashboard_pelamar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/logo1ABC.png" alt="Logo" style="height: 40px;" />
            <span class="welcome-text">Selamat Datang, <?= htmlspecialchars($nama_pelamar) ?>!</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard_pelamar.php"><i class="bi bi-briefcase"></i> Lowongan</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="lamaran_saya.php"><i class="bi bi-send"></i> Proses Lamaran</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pengumuman_pelamar.php"><i class="bi bi-bell"></i> Pengumuman</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="login_ujian_pelamar.php"><i class="bi bi-journal-text"></i> Ujian</a></li>
                <li class="nav-item"><a class="nav-link text-warning fw-bold" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Konten -->
<div class="container mt-5 mb-5">
    <h3 class="mb-4 text-center fw-bold">Status Lamaran Anda</h3>

    <?php if ($data && $data['posisi_dilamar']): ?>
        <div class="card p-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-badge"></i> <?= htmlspecialchars($data['nama']) ?></h5>
                <p class="mb-2"><strong>Posisi Dilamar:</strong> <?= htmlspecialchars($data['posisi_dilamar']) ?></p>
                <p class="mb-0">
                    <strong>Status Lamaran:</strong> 
                    <span class="status <?= $class_status ?>">
                        <?= htmlspecialchars($data['status_lamaran'] ?: 'Belum Diproses') ?>
                    </span>
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center fw-semibold">Anda belum melamar pekerjaan.</div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; <?= date("Y") ?> Dashboard Pelamar - PT ABC. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
