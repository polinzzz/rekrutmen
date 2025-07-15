<?php
include 'admin/koneksi.php';

if (isset($_POST['simpan'])) {
    // Ambil data dari form dan sanitasi input
    $posisi        = mysqli_real_escape_string($conn, trim($_POST['posisi']));
    $deskripsi     = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
    $lokasi        = mysqli_real_escape_string($conn, trim($_POST['lokasi']));
    $tanggal_post  = date('Y-m-d');
    $batas_akhir   = mysqli_real_escape_string($conn, trim($_POST['batas_akhir']));

    // Validasi input kosong
    if (empty($posisi) || empty($deskripsi) || empty($lokasi) || empty($batas_akhir)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit();
    }

    // Validasi upload gambar
    if (!isset($_FILES['foto_deskripsi']) || $_FILES['foto_deskripsi']['error'] !== 0) {
        echo "<script>alert('Gagal mengunggah gambar!'); window.history.back();</script>";
        exit();
    }

    $fotoName = $_FILES['foto_deskripsi']['name'];
    $fotoTmp = $_FILES['foto_deskripsi']['tmp_name'];
    $fotoExt = strtolower(pathinfo($fotoName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fotoExt, $allowedExt)) {
        echo "<script>alert('Format gambar tidak diizinkan!'); window.history.back();</script>";
        exit();
    }

    // Rename dan simpan gambar
    $newFotoName = uniqid('low_', true) . '.' . $fotoExt;
    $uploadPath = 'uploads/' . $newFotoName;

    if (!move_uploaded_file($fotoTmp, $uploadPath)) {
        echo "<script>alert('Gagal menyimpan gambar!'); window.history.back();</script>";
        exit();
    }

    // Query INSERT
    $query = "INSERT INTO lowongan (Posisi, deskripsi, lokasi, tanggal_post, batas_akhir, foto_deskripsi)
              VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $posisi, $deskripsi, $lokasi, $tanggal_post, $batas_akhir, $newFotoName);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Lowongan berhasil ditambahkan!'); window.location='admin_lowongan.php?page=admin_lowongan';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan lowongan: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Query tidak dapat diproses: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }

    mysqli_close($conn);
} else {
    echo "<script>alert('Akses tidak sah!'); window.location='admin_lowongan.php';</script>";
}
?>
