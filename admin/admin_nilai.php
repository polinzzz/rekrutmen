<?php
session_start();
include 'koneksi.php';  // Pastikan file koneksi.php ada dan benar

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Anda harus login sebagai admin!'); window.location='login.php';</script>";
    exit;
}

// Query untuk ambil nilai pelamar dengan perhitungan nilai yang aman
$query = "
SELECT
  p.nik,
  p.nama,
  p.email,
  IFNULL(SUM(j.is_benar), 0) AS total_benar,
  IFNULL(COUNT(j.soal_id), 0) AS total_soal,
  CASE WHEN COUNT(j.soal_id) > 0 THEN (SUM(j.is_benar) / COUNT(j.soal_id)) * 100 ELSE 0 END AS nilai
FROM pelamar p
LEFT JOIN jawaban_pelamar j ON p.nik = j.pelamar_nik
GROUP BY p.nik, p.nama, p.email
ORDER BY nilai DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Nilai Pelamar - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>


<div class="container">
    <h2 class="mb-4">Daftar Nilai Ujian Pelamar</h2>
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jumlah Benar</th>
                <th>Jumlah Soal</th>
                <th>Nilai (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nik']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . (int)$row['total_benar'] . "</td>";
                    echo "<td>" . (int)$row['total_soal'] . "</td>";
                    echo "<td>" . number_format($row['nilai'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Belum ada data nilai.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
