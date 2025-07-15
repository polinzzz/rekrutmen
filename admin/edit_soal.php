<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM soal_ujian WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pertanyaan = $_POST['pertanyaan'];
    $pilihan_a = $_POST['pilihan_a'];
    $pilihan_b = $_POST['pilihan_b'];
    $pilihan_c = $_POST['pilihan_c'];
    $pilihan_d = $_POST['pilihan_d'];
    $jawaban = $_POST['jawaban'];

    mysqli_query($conn, "UPDATE soal_ujian 
                         SET pertanyaan = '$pertanyaan',
                             pilihan_a = '$pilihan_a',
                             pilihan_b = '$pilihan_b',
                             pilihan_c = '$pilihan_c',
                             pilihan_d = '$pilihan_d',
                             jawaban = '$jawaban'
                         WHERE id = '$id'");

    header("Location: ujian_pelamar_admin.php?msg=" . urlencode("✅ Soal berhasil diperbarui."));
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Soal Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">✏️ Edit Soal Ujian</h2>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Pertanyaan:</label>
            <textarea class="form-control" name="pertanyaan" rows="4" required><?= htmlspecialchars($data['pertanyaan']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilihan A:</label>
            <input type="text" class="form-control" name="pilihan_a" value="<?= htmlspecialchars($data['pilihan_a']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilihan B:</label>
            <input type="text" class="form-control" name="pilihan_b" value="<?= htmlspecialchars($data['pilihan_b']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilihan C:</label>
            <input type="text" class="form-control" name="pilihan_c" value="<?= htmlspecialchars($data['pilihan_c']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilihan D:</label>
            <input type="text" class="form-control" name="pilihan_d" value="<?= htmlspecialchars($data['pilihan_d']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jawaban Benar:</label>
            <select name="jawaban" class="form-select" required>
                <option value="a" <?= $data['jawaban'] == 'a' ? 'selected' : '' ?>>A</option>
                <option value="b" <?= $data['jawaban'] == 'b' ? 'selected' : '' ?>>B</option>
                <option value="c" <?= $data['jawaban'] == 'c' ? 'selected' : '' ?>>C</option>
                <option value="d" <?= $data['jawaban'] == 'd' ? 'selected' : '' ?>>D</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="ujian_pelamar_admin.php" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-success">💾 Update Soal</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
