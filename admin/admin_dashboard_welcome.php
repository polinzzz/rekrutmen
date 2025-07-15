<?php
include 'koneksi.php';
session_start();

// Ambil data untuk statistik dengan menggunakan query yang aman
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pelamar"))['total'];
$diterima = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS diterima FROM pelamar WHERE status_lamaran = 'Diterima'"))['diterima'];
$ditolak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS ditolak FROM pelamar WHERE status_lamaran = 'Ditolak'"))['ditolak'];

// Ambil data pelamar
$pelamar = mysqli_query($conn, "SELECT * FROM pelamar");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">📊 Dashboard Admin</h2>

    <!-- Notifikasi -->
    <?php if (isset($_SESSION['pesan'])) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['pesan'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
        <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <!-- Statistik Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Pelamar</h5>
                    <p class="card-text fs-3"><?= $total ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow text-white bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Pelamar Diterima</h5>
                    <p class="card-text fs-3"><?= $diterima ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow text-white bg-danger">
                <div class="card-body text-center">
                    <h5 class="card-title">Pelamar Ditolak</h5>
                    <p class="card-text fs-3"><?= $ditolak ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram -->
    

    <!-- Tabel Data Pelamar -->
    <div class="card shadow p-4 mb-5">
        <h4>Data Pelamar</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Status Lamaran</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($pelamar)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['nik']) ?></td>
                        <td>
                           
                                 <select class="form-select form-select-sm" disabled>
                                <option <?= $row['status_lamaran'] == 'Menunggu ' ? 'selected' : '' ?>>Menunggu </option>
                                <option <?= $row['status_lamaran'] == 'Lolos Administrasi' ? 'selected' : '' ?>>Lolos Administrasi</option>
                                <option <?= $row['status_lamaran'] == 'Ujian' ? 'selected' : '' ?>>Ujian </option>
                                <option <?= $row['status_lamaran'] == 'Lolos_Ujian' ? 'selected' : '' ?>>Lolos Ujian</option>
                                <option <?= $row['status_lamaran'] == 'Gagal_Ujian' ? 'selected' : '' ?>>Gagal Ujian </option>
                                <option <?= $row['status_lamaran'] == 'Interview' ? 'selected' : '' ?>>Interview</option>
                                <option <?= $row['status_lamaran'] == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                                <option <?= $row['status_lamaran'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function ubahStatus(id, status) {
    $.get('ubah_status_lamaran.php', { id: id, status: status })
        .done(function () {
            location.reload(); // Refresh untuk menampilkan notifikasi
        })
        .fail(function () {
            alert('Terjadi kesalahan saat mengubah status.');
        });
}

// Chart
const ctx = document.getElementById('diagramPelamar').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Diterima', 'Ditolak', 'Total Lainnya'],
        datasets: [{
            label: 'Jumlah',
            data: [<?= $diterima ?>, <?= $ditolak ?>, <?= $total - $diterima - $ditolak ?>],
            backgroundColor: ['#198754', '#dc3545', '#0d6efd'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
