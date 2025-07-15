<?php
include 'koneksi.php';

// Query untuk mengambil data lowongan
$query = "SELECT * FROM lowongan ORDER BY tanggal_post DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Lowongan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .content {
            margin-left: 120px; /* Sesuaikan dengan lebar sidebar di admin_dashboard.php */
            padding: 40px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .btn-action {
            display: flex;
            justify-content: space-around;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .form-tambah {
            margin-top: 20px;
        }
        img.foto-lowongan {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="content" id="main-content">
    <h2 class="fw-bold">Kelola Lowongan</h2>
    <p class="text-muted">Tambah, edit, atau hapus lowongan kerja yang tersedia.</p>

    <!-- Link ke form tambah lowongan terpisah -->
    <a href="tambah_lowongan.php" class="btn btn-primary mb-3">+ Tambah Lowongan</a>

    <!-- Tabel Lowongan -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Posisi</th>
                    <th>Deskripsi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Dibuka</th>
                    <th>Tanggal Ditutup</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td>" . htmlspecialchars($row['Posisi']) . "</td>";
                        echo "<td>" . nl2br(htmlspecialchars($row['deskripsi'])) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";
                        echo "<td class='text-center'>" . htmlspecialchars($row['tanggal_post']) . "</td>";
                        echo "<td class='text-center'>" . htmlspecialchars($row['batas_akhir']) . "</td>";

                        // Cek dan tampilkan gambar jika ada
                        if (!empty($row['foto_deskripsi']) && file_exists('uploads/' . $row['foto_deskripsi'])) {
                            echo "<td class='text-center'><img src='uploads/" . htmlspecialchars($row['foto_deskripsi']) . "' alt='Foto Lowongan' class='foto-lowongan'></td>";
                        } else {
                            echo "<td class='text-center text-muted'>-</td>";
                        }

                        echo "<td class='text-center btn-action'>
                            <a href='edit_lowongan.php?edit={$row['ID']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='hapus_lowongan.php?id={$row['ID']}' onclick=\"return confirm('Yakin ingin menghapus lowongan ini?');\" class='btn btn-danger btn-sm'>Hapus</a>
                        </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center text-muted'>Belum ada lowongan tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
