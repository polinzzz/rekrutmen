<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pelamar'])) {
    header("Location: login.php");
    exit;
}

$posisi = isset($_GET['posisi']) ? urldecode($_GET['posisi']) : '';
$pelamar_email = $_SESSION['pelamar']; // Pastikan ini adalah email atau ID pelamar

// Ambil data pelamar berdasarkan email
$query = mysqli_query($conn, "SELECT * FROM pelamar WHERE email = '$pelamar_email'");
$pelamar = mysqli_fetch_assoc($query);

// Jika sudah pernah melamar (kolom posisi tidak kosong), redirect ke lamaran_saya
if (!empty($pelamar['posisi'])) {
    header("Location: lamaran_saya.php");
    exit;
}

// Validasi jika posisi kosong
if (empty($posisi)) {
    echo "<script>alert('Posisi tidak valid.'); window.location.href='lowongan_pelamar.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Lamaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Form Lamaran - Posisi: <?= htmlspecialchars($posisi) ?></h3>

    <form action="proses_lamaran.php" method="POST" enctype="multipart/form-data">
        <!-- Kirim posisi yang dilamar ke backend -->
        <input type="hidden" name="posisi_dilamar" value="<?= htmlspecialchars($posisi) ?>">

        <!-- Data Diri -->
        <h5>Data Diri</h5>
        <div class="row">
            <div class="col-md-6 mb-3"><label>NIK</label><input type="text" class="form-control" name="nik" required></div>
            <div class="col-md-6 mb-3"><label>Nama Lengkap</label><input type="text" class="form-control" name="nama" required></div>
            <div class="col-md-6 mb-3"><label>Email</label><input type="email" class="form-control" name="email" required value="<?= htmlspecialchars($pelamar_email) ?>" readonly></div>
            <div class="col-md-6 mb-3"><label>Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir" required></div>
            <div class="col-md-6 mb-3"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" required></div>
            <div class="col-md-6 mb-3"><label>Jenis Kelamin</label>
                <select class="form-control" name="jk" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-6 mb-3"><label>Status Pernikahan</label><input type="text" class="form-control" name="status_pernikahan" required></div>
            <div class="col-md-6 mb-3"><label>Kewarganegaraan</label><input type="text" class="form-control" name="kewarganegaraan" required></div>
            <div class="col-md-12 mb-3"><label>Alamat</label><textarea class="form-control" name="alamat" rows="3" required></textarea></div>
            <div class="col-md-6 mb-3"><label>Foto Diri</label><input type="file" class="form-control" name="foto" accept="image/*" required></div>
        </div>

        <!-- Pendidikan -->
        <h5 class="mt-4">Pendidikan Terakhir</h5>
        <div class="row">
            <div class="col-md-4 mb-3"><label>Jenjang</label><input type="text" class="form-control" name="jenjang" required></div>
            <div class="col-md-4 mb-3"><label>Instansi</label><input type="text" class="form-control" name="instansi" required></div>
            <div class="col-md-4 mb-3"><label>Jurusan</label><input type="text" class="form-control" name="jurusan" required></div>
            <div class="col-md-3 mb-3"><label>IPK</label><input type="text" class="form-control" name="ipk" required></div>
            <div class="col-md-3 mb-3"><label>Tahun Masuk</label><input type="text" class="form-control" name="tahun_masuk" required></div>
            <div class="col-md-3 mb-3"><label>Tahun Keluar</label><input type="text" class="form-control" name="tahun_keluar" required></div>
        </div>

        <!-- Pengalaman Kerja -->
        <h5 class="mt-4">Tempat Kerja Sebelumnya</h5>
        <div class="row">
            <div class="col-md-6 mb-3"><label>Nama Perusahaan</label><input type="text" class="form-control" name="nama_perusahaan" required></div>
            <div class="col-md-3 mb-3"><label>Tahun Masuk</label><input type="text" class="form-control" name="tahun_masuk_kerja" required></div>
            <div class="col-md-3 mb-3"><label>Tahun Keluar</label><input type="text" class="form-control" name="tahun_keluar_kerja" required></div>
            <div class="col-md-6 mb-3"><label>Gaji Sebelumnya</label><input type="text" class="form-control" name="gaji_sebelumnya" required></div>
            <div class="col-md-6 mb-3"><label>Alasan Keluar</label><textarea class="form-control" name="alasan_keluar" required></textarea></div>
        </div>

        <!-- Dokumen Pendukung -->
        <h5 class="mt-4">Dokumen Pendukung (PDF/IMG)</h5>
        <div class="row">
            <div class="col-md-6 mb-3"><label>Foto KTP</label><input type="file" name="foto_ktp" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label>Ijazah</label><input type="file" name="ijazah" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label>Transkrip</label><input type="file" name="transkrip" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label>Sertifikat</label><input type="file" name="sertifikat" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>SKCK</label><input type="file" name="skck" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>NPWP</label><input type="file" name="npwp" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>Vaksin Dosis 1</label><input type="file" name="vaksin1" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>Vaksin Dosis 2</label><input type="file" name="vaksin2" class="form-control"></div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Kirim Lamaran</button>
        <a href="lowongan_pelamar.php" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
</body>
</html>
