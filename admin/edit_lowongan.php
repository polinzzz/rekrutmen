<?php
include 'koneksi.php';

// Proses update
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $posisi = $_POST['posisi'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $tanggal_dibuka = $_POST['tanggal_dibuka'];
    $batas_akhir = $_POST['batas_akhir'];

    // Ambil data gambar lama dulu
    $queryOld = "SELECT foto_deskripsi FROM lowongan WHERE ID = ?";
    $stmtOld = mysqli_prepare($conn, $queryOld);
    mysqli_stmt_bind_param($stmtOld, 'i', $id);
    mysqli_stmt_execute($stmtOld);
    $resultOld = mysqli_stmt_get_result($stmtOld);
    $oldData = mysqli_fetch_assoc($resultOld);
    mysqli_stmt_close($stmtOld);

    $foto_lama = $oldData['foto_deskripsi'];

    // Proses upload gambar baru jika ada
    if (isset($_FILES['foto_deskripsi']) && $_FILES['foto_deskripsi']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto_deskripsi']['tmp_name'];
        $fileName = $_FILES['foto_deskripsi']['name'];
        $fileSize = $_FILES['foto_deskripsi']['size'];
        $fileType = $_FILES['foto_deskripsi']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Tentukan ekstensi yang diizinkan
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Nama baru agar tidak bentrok
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Path upload
            $uploadFileDir = './uploads/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Hapus gambar lama jika ada dan bukan file kosong
                if ($foto_lama && file_exists($uploadFileDir . $foto_lama)) {
                    unlink($uploadFileDir . $foto_lama);
                }
                $foto_lama = $newFileName; // Update nama file di DB nanti
            } else {
                echo "<script>alert('Terjadi kesalahan saat upload gambar.');</script>";
            }
        } else {
            echo "<script>alert('Format gambar tidak didukung. Gunakan jpg, jpeg, png, atau gif.');</script>";
        }
    }

    // Validasi input (sederhana)
    if ($posisi && $deskripsi && $lokasi && $tanggal_dibuka && $batas_akhir) {
        $query = "UPDATE lowongan SET Posisi = ?, deskripsi = ?, lokasi = ?, tanggal_post = ?, batas_akhir = ?, foto_deskripsi = ? WHERE ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssssi', $posisi, $deskripsi, $lokasi, $tanggal_dibuka, $batas_akhir, $foto_lama, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php"); // Redirect ke halaman lowongan
        exit;
    }
}

// Ambil data untuk edit
$editMode = false;
$editData = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM lowongan WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $resultEdit = mysqli_stmt_get_result($stmt);
    $editData = mysqli_fetch_assoc($resultEdit);
    mysqli_stmt_close($stmt);

    if (!$editData) {
        echo "<script>alert('Lowongan tidak ditemukan!'); window.location='admin_dashboard.php?page=admin_lowongan';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='admin_dashboard.php?page=admin_lowongan';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Lowongan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2 class="fw-bold">Edit Lowongan</h2>
    <p class="text-muted">Edit informasi lowongan yang telah dipilih.</p>

    <form action="edit_lowongan.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editData['ID']; ?>">

        <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" name="posisi" id="posisi" class="form-control" value="<?php echo htmlspecialchars($editData['Posisi']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($editData['deskripsi']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?php echo htmlspecialchars($editData['lokasi']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_dibuka" class="form-label">Tanggal Dibuka</label>
            <input type="date" name="tanggal_dibuka" id="tanggal_dibuka" class="form-control" value="<?php echo htmlspecialchars($editData['tanggal_post']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="batas_akhir" class="form-label">Tanggal Ditutup</label>
            <input type="date" name="batas_akhir" id="batas_akhir" class="form-control" value="<?php echo htmlspecialchars($editData['batas_akhir']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="foto_deskripsi" class="form-label">Foto Lowongan (kosongkan jika tidak ingin mengganti)</label>
            <input type="file" name="foto_deskripsi" id="foto_deskripsi" class="form-control" accept="image/*" >
        </div>

        <?php if (!empty($editData['foto_deskripsi'])): ?>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini:</label><br>
                <img src="uploads/<?php echo htmlspecialchars($editData['foto_deskripsi']); ?>" alt="Foto Lowongan" style="max-width: 200px; max-height: 150px; border: 1px solid #ccc; padding: 5px;">
            </div>
        <?php endif; ?>

        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
