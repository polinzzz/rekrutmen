<?php
include 'koneksi.php'; // Pastikan koneksi sudah benar

$query = "SELECT * FROM lowongan ORDER BY tanggal_post DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Lowongan Kerja Tersedia</h2>

        <div class="row">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['Posisi']); ?></h5>
                                <p class="card-text"><strong>Lokasi:</strong> <?php echo htmlspecialchars($row['lokasi']); ?></p>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                                <p class="text-muted">
                                    <small>
                                        Dibuka: <?php echo $row['tanggal_post']; ?> |
                                        Ditutup: <?php echo $row['batas_akhir']; ?>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        Belum ada lowongan kerja yang tersedia saat ini.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
