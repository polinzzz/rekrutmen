<?php
session_start();
if (!isset($_SESSION['pelamar'])) {
    header("Location: admin/login.php");
    exit;
}

include 'koneksi.php';

$email = $_SESSION['pelamar'];

// Ambil data pelamar berdasarkan email
$query_lamaran = "SELECT * FROM pelamar WHERE email = '$email' LIMIT 1";
$result_lamaran = mysqli_query($conn, $query_lamaran);
$data_pelamar = mysqli_fetch_assoc($result_lamaran);
$nama = $data_pelamar ? $data_pelamar['nama'] : 'Pelamar';

// Ambil semua lowongan
$query = "SELECT * FROM lowongan ORDER BY tanggal_post DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Pelamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        footer {
            background-color: #0d6efd;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 60px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .btn-lamar {
            background-color: #0d6efd;
            border: none;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            color: white;
            text-decoration: none;
        }
        .btn-lamar:hover {
            background-color: #0843b5;
            color: white;
        }
        h3 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 40px;
            text-align: center;
        }
        .lowongan-lokasi,
        .lowongan-batas {
            font-size: 0.9rem;
            color: #495057;
            margin-top: 6px;
            font-weight: 500;
        }
        .lowongan-batas {
            color: #d6336c;
            font-weight: 600;
        }
        .navbar-brand img {
            filter: drop-shadow(0 0 2px rgba(0,0,0,0.25));
        }
        .welcome-text {
            color: white;
            margin-left: 10px;
            font-weight: 600;
        }
        .no-lowongan {
            font-style: italic;
            color: #6c757d;
            text-align: center;
            margin-top: 50px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/logo1ABC.png" alt="Logo" style="height: 40px;" />
            <div class="welcome-text d-flex flex-column ms-2">
    <span class="fw-semibold">Selamat Datang, <?= htmlspecialchars($nama) ?></span>
</div>

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

<div class="container mt-5 mb-5">
    <h3>Lowongan Tersedia</h3>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card h-100">
                        <?php
                        $gambar = $row['foto_deskripsi'];
                        $path_gambar = "admin/uploads/" . $gambar;
                        if (!empty($gambar) && file_exists($path_gambar)): ?>
                            <img src="<?= htmlspecialchars($path_gambar) ?>" alt="Gambar Lowongan" class="card-img-top" />
                        <?php else: ?>
                            <img src="https://via.placeholder.com/600x180?text=No+Image+Available" alt="No Image Available" class="card-img-top" />
                        <?php endif; ?>

                        <div class="card-body">
                            <div>
                                <h5 class="card-title fw-bold text-primary"><?= htmlspecialchars($row['Posisi']) ?></h5>
                                <p class="card-text text-secondary" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                                <p class="lowongan-lokasi"><i class="bi bi-geo-alt-fill"></i> Lokasi: <strong><?= htmlspecialchars($row['lokasi']) ?></strong></p>
                                <p class="lowongan-batas">Batas Pendaftaran: <strong><?= htmlspecialchars($row['batas_akhir']) ?></strong></p>
                            </div>
                            <a href="lamaran.php?posisi=<?= urlencode($row['Posisi']) ?>" class="btn-lamar mt-2"><i class="bi bi-pencil-square"></i> Lamar Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="no-lowongan">Belum ada lowongan tersedia saat ini.</p>
    <?php endif; ?>

    <?php if (!$data_pelamar): ?>
        <div class="alert alert-warning mt-5 text-center fw-semibold">Anda belum mengirimkan lamaran pekerjaan.</div>
    <?php endif; ?>
</div>

<footer>
    <div class="container">
        <p>&copy; <?= date("Y") ?> Dashboard Pelamar - PT ABC. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
