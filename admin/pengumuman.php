<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$pesan = isset($_GET['pesan']) ? urldecode($_GET['pesan']) : "";

// Ambil daftar pengumuman
$hasil = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-4">📢 Daftar Pengumuman</h3>

    <?php if ($pesan): ?>
        <div class="alert alert-info"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah Pengumuman -->
    <a href="tambah_pengumuman.php" class="btn btn-success mb-3">+ Tambah Pengumuman</a>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Aksi</th>
            </tr>
        </thead>  
        <tbody>
            <?php if (mysqli_num_rows($hasil) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($hasil)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['isi']) ?></td>
                        <td>
                            <!-- Tombol Hapus -->
                            <a href="hapus_pengumuman.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">Belum ada pengumuman.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
