<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['pelamar'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

$nik = $_SESSION['pelamar'];
$nilai = null;
$jumlah_soal = 0;
$total_benar = 0;
$soal_list = [];

// Ambil semua soal
$result = mysqli_query($conn, "SELECT * FROM soal_ujian");
while ($row = mysqli_fetch_assoc($result)) {
    $soal_list[] = $row;
}

// Cek apakah pelamar sudah pernah mengisi jawaban
$stmt_cek = $conn->prepare("SELECT COUNT(*) as total FROM jawaban_pelamar WHERE pelamar_nik = ?");
$stmt_cek->bind_param("s", $nik);
$stmt_cek->execute();
$result_cek = $stmt_cek->get_result()->fetch_assoc();
$sudah_ujian = $result_cek['total'] > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$sudah_ujian) {
    $jawaban = $_POST['jawaban'] ?? [];

    foreach ($soal_list as $row) {
        $jumlah_soal++;
        $id = $row['id'];
        $jawaban_benar = strtolower(trim($row['jawaban']));
        $jawab_user = isset($jawaban[$id]) ? strtolower(trim($jawaban[$id])) : '';

        $is_benar = ($jawab_user === $jawaban_benar) ? 1 : 0;
        if ($is_benar) $total_benar++;

        $stmt = $conn->prepare("INSERT INTO jawaban_pelamar (pelamar_nik, soal_id, jawaban, is_benar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $nik, $id, $jawab_user, $is_benar);
        $stmt->execute();
    }

    $nilai = ($jumlah_soal > 0) ? ($total_benar / $jumlah_soal) * 100 : 0;
    $sudah_ujian = true;
} elseif ($sudah_ujian) {
    // Hitung nilai dari data jawaban sebelumnya
    $stmt_nilai = $conn->prepare("SELECT COUNT(*) as total, SUM(is_benar) as benar FROM jawaban_pelamar WHERE pelamar_nik = ?");
    $stmt_nilai->bind_param("s", $nik);
    $stmt_nilai->execute();
    $res = $stmt_nilai->get_result()->fetch_assoc();
    $jumlah_soal = $res['total'];
    $total_benar = $res['benar'];
    $nilai = ($jumlah_soal > 0) ? ($total_benar / $jumlah_soal) * 100 : 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background: #fff;
            padding: 30px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-check {
            margin-bottom: 10px;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 30px;
        }
    </style>
</head>
<body>
<div class="container position-relative">
    <a href="logout_ujian.php" class="btn btn-danger logout">Logout</a>
    <h3 class="mb-4 text-center text-primary">📝 Ujian Online Pilihan Ganda</h3>

    <?php if ($nilai !== null): ?>
        <div class="alert alert-info text-center">
            <h4>Nilai Anda: <?= round($nilai, 2) ?>%</h4>
            <p><strong><?= $total_benar ?></strong> jawaban benar dari <strong><?= $jumlah_soal ?></strong> soal.</p>
        </div>
        <hr>
    <?php endif; ?>

    <?php if (!$sudah_ujian): ?>
        <form action="" method="POST">
            <?php $no = 1; ?>
            <?php foreach ($soal_list as $row): ?>
                <div class="mb-4">
                    <label class="fw-semibold"><?= $no++ ?>. <?= htmlspecialchars($row['pertanyaan']) ?></label><br>
                    <?php foreach (['a', 'b', 'c', 'd'] as $opt): ?>
                        <?php $value = htmlspecialchars($row["pilihan_$opt"]); ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                name="jawaban[<?= $row['id'] ?>]" 
                                id="soal<?= $row['id'] . $opt ?>" 
                                value="<?= $opt ?>" 
                                required>
                            <label class="form-check-label" for="soal<?= $row['id'] . $opt ?>">
                                <?= strtoupper($opt) ?>. <?= $value ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <div class="text-center">
                <button type="submit" class="btn btn-success">📤 Kirim Jawaban</button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <strong>⚠️ Anda sudah mengerjakan ujian ini. Jawaban tidak dapat diubah.</strong>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
