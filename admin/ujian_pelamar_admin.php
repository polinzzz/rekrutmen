<?php
include 'koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Soal Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">📋 Daftar Soal Ujian </h2>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="admin_dashboard.php?page=admin_dashboard_welcome.phpn" class="btn btn-secondary">🔙 Kembali ke Menu Admin</a>
        <a href="tambah_soal.php" class="btn btn-primary">➕ Tambah Soal Baru</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>Jawaban Benar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $result = mysqli_query($conn, "SELECT * FROM soal_ujian");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= nl2br(htmlspecialchars($row['pertanyaan'])) ?></td>
                        <td><?= htmlspecialchars($row['pilihan_a']) ?></td>
                        <td><?= htmlspecialchars($row['pilihan_b']) ?></td>
                        <td><?= htmlspecialchars($row['pilihan_c']) ?></td>
                        <td><?= htmlspecialchars($row['pilihan_d']) ?></td>
                        <td class="text-center fw-bold text-success"><?= strtoupper($row['jawaban']) ?></td>
                        <td class="text-center">
                            <a href="edit_soal.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <a href="hapus_soal.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus soal ini?')">🗑️ Hapus</a>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="8" class="text-center text-muted">Belum ada soal ujian.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
