<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$pesan = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $isi = trim($_POST['isi']);

    if ($judul && $isi) {
        $stmt = mysqli_prepare($conn, "INSERT INTO pengumuman (judul, isi) VALUES (?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $judul, $isi);
            if (mysqli_stmt_execute($stmt)) {
                $pesan = "✅ Pengumuman berhasil ditambahkan.";
                header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php?pesan=" . urlencode($pesan));
                exit();
            } else {
                $pesan = "❌ Gagal menambahkan pengumuman: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $pesan = "❌ Gagal menyiapkan query: " . mysqli_error($conn);
        }
    } else {
        $pesan = "❌ Judul dan Isi wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengumuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>📢 Tambah Pengumuman</h3>

    <?php if ($pesan): ?>
        <div class="alert alert-info"><?= $pesan ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Isi Pengumuman</label>
            <textarea name="isi" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
