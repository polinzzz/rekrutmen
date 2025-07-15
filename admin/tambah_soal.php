<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pertanyaan = $_POST['pertanyaan'];
    $pilihan_a = $_POST['pilihan_a'];
    $pilihan_b = $_POST['pilihan_b'];
    $pilihan_c = $_POST['pilihan_c'];
    $pilihan_d = $_POST['pilihan_d'];
    $jawaban = $_POST['jawaban'];

    $query = "INSERT INTO soal_ujian (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban)
              VALUES ('$pertanyaan', '$pilihan_a', '$pilihan_b', '$pilihan_c', '$pilihan_d', '$jawaban')";

    mysqli_query($conn, $query);

    // Redirect ke halaman admin dengan pesan sukses
    header("Location: ujian_pelamar_admin.php?msg=" . urlencode("✅ Soal berhasil ditambahkan."));
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">➕ Tambah Soal Ujian</h2>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan:</label>
            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilihan A:</label>
            <input type="text" class="form-control" name="pilihan_a" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilihan B:</label>
            <input type="text" class="form-control" name="pilihan_b" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilihan C:</label>
            <input type="text" class="form-control" name="pilihan_c" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilihan D:</label>
            <input type="text" class="form-control" name="pilihan_d" required>
        </div>

        <div class="mb-3">
            <label for="jawaban" class="form-label">Jawaban Benar:</label>
            <select name="jawaban" id="jawaban" class="form-select" required>
                <option value="">-- Pilih Jawaban Benar --</option>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="ujian_pelamar_admin.php" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Soal</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
