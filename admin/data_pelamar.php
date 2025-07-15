<?php
include 'koneksi.php';
session_start();

$query = "SELECT p.*, d.foto_ktp, d.ijazah, d.transkrip, d.sertifikat, d.skck, d.npwp, d.vaksin1, d.vaksin2
          FROM pelamar p
          LEFT JOIN dokumen_pendukung d ON p.id = d.pelamar_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td { vertical-align: middle; }
        .badge-custom {
            background-color: #0d6efd;
            color: white;
            padding: 0.4em 0.7em;
            border-radius: 0.5rem;
            text-decoration: none;
        }
        .card-foto {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }
        .dokumen-link {
            display: inline-block;
            margin: 2px 0;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">📄 Data Pelamar</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm bg-white">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Posisi Dilamar</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    <th>Agama</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Kewarganegaraan</th>
                    <th>Foto</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                    <th>Status Lamaran</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $statusList = [
                    'Menunggu' => 'info',
                    'Lolos Administrasi' => 'secondary',
                    'Ujian' => 'info',
                    'Lolos_Ujian' => 'info',
                    'Gagal_Ujian' => 'info',
                    'Interview' => 'primary',
                    'Diterima' => 'success',
                    'Ditolak' => 'danger'
                ];

                while($row = mysqli_fetch_assoc($result)) :
                    $currentStatus = $row['status_lamaran'] ?? 'Lolos Administrasi';
                    $badgeClass = $statusList[$currentStatus] ?? 'secondary';
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['posisi_dilamar']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['nik']) ?></td>
                    <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                    <td><?= htmlspecialchars($row['tempat_lahir']) . ', ' . date('d-m-Y', strtotime($row['tanggal_lahir'])) ?></td>
                    <td class="text-center"><span class="badge bg-info text-dark"><?= htmlspecialchars($row['jk']) ?></span></td>
                    <td><?= htmlspecialchars($row['agama']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td class="text-center"><span class="badge bg-success"><?= htmlspecialchars($row['status_pernikahan']) ?></span></td>
                    <td class="text-center"><?= htmlspecialchars($row['kewarganegaraan']) ?></td>
                    <td class="text-center">
                        <?php if (!empty($row['foto'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" class="card-foto" alt="Foto Pelamar">
                        <?php else: ?>
                            <span class="text-muted">Tidak ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                        $dokumen = [
                            'foto_ktp' => 'KTP', 'ijazah' => 'Ijazah', 'transkrip' => 'Transkrip',
                            'sertifikat' => 'Sertifikat', 'skck' => 'SKCK', 'npwp' => 'NPWP',
                            'vaksin1' => 'Vaksin 1', 'vaksin2' => 'Vaksin 2'
                        ];
                        $hasDokumen = false;
                        foreach ($dokumen as $key => $label):
                            if (!empty($row[$key])):
                                $hasDokumen = true;
                        ?>
                            <a href="uploads/<?= htmlspecialchars($row[$key]) ?>" class="badge-custom dokumen-link" target="_blank"><?= $label ?></a><br>
                        <?php endif; endforeach; ?>
                        <?php if (!$hasDokumen): ?>
                            <span class="text-muted">Tidak ada dokumen</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="edit_pelamar.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <a href="hapus_pelamar.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-<?= $badgeClass ?>"><?= htmlspecialchars($currentStatus) ?></span><br><br>
                        <?php foreach ($statusList as $status => $btnClass): ?>
                            <?php if ($status !== $currentStatus): ?>
                                <a href="ubah_status_lamaran.php?id=<?= urlencode($row['id']) ?>&status=<?= urlencode($status) ?>" class="btn btn-sm btn-<?= $btnClass ?> mb-1" onclick="return confirm('Ubah status menjadi <?= $status ?>?')"><?= $status ?></a><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($result) === 0): ?>
                <tr>
                    <td colspan="15" class="text-center text-muted">Belum ada data pelamar.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
