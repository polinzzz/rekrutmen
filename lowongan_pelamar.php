<?php
session_start();
if (!isset($_SESSION['pelamar'])) {
    header("Location: admin/login.php");
    exit;
}

include 'koneksi.php';

// Ambil semua lowongan
$query = "SELECT * FROM lowongan ORDER BY tanggal_post DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lowongan Pekerjaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Lowongan Tersedia</h3>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['Posisi']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                    <p class="card-text"><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']) ?></p>
                    <p class="card-text"><strong>Ditutup:</strong> <?= htmlspecialchars($row['batas_akhir']) ?></p>
                    <a href="lamaran.php?posisi=<?= urlencode($row['Posisi']) ?>" class="btn btn-primary btn-sm">Lamar Sekarang</a>

                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-muted">Belum ada lowongan tersedia.</p>
    <?php endif; ?>
</div>
</body>
</html>
