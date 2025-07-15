<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $posisi = $_POST['Posisi'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $tanggal_post = $_POST['tanggal_post'];
    $batas_akhir = $_POST['batas_akhir'];

    // Handle upload gambar
    if (isset($_FILES['foto_deskripsi']) && $_FILES['foto_deskripsi']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto_deskripsi']['tmp_name'];
        $fileName = $_FILES['foto_deskripsi']['name'];
        $fileSize = $_FILES['foto_deskripsi']['size'];
        $fileType = $_FILES['foto_deskripsi']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed extensions
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Buat nama file unik agar tidak overwrite
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Lokasi folder upload
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Simpan nama file ke database
                if ($posisi && $deskripsi && $lokasi && $tanggal_post && $batas_akhir) {
                    $query = "INSERT INTO lowongan (Posisi, deskripsi, lokasi, tanggal_post, batas_akhir, foto_deskripsi) 
                              VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, 'ssssss', $posisi, $deskripsi, $lokasi, $tanggal_post, $batas_akhir, $newFileName);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php");
                    exit;
                } else {
                    echo "Semua field harus diisi!";
                }
            } else {
                echo "Terjadi kesalahan saat memindahkan file.";
            }
        } else {
            echo "Upload gagal. Format file hanya diperbolehkan: " . implode(", ", $allowedfileExtensions);
        }
    } else {
        echo "Gambar harus diupload.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Lowongan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">
    <h2 class="fw-bold">Tambah Lowongan</h2>
    <p class="text-muted">Masukkan informasi lowongan baru.</p>

    <form action="tambah_lowongan.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="Posisi" class="form-label">Posisi</label>
            <input type="text" name="Posisi" id="Posisi" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="tanggal_post" class="form-label">Tanggal Dibuka</label>
            <input type="date" name="tanggal_post" id="tanggal_post" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="batas_akhir" class="form-label">Tanggal Ditutup</label>
            <input type="date" name="batas_akhir" id="batas_akhir" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="foto_deskripsi" class="form-label">Foto Pekerjaan (jpg, jpeg, png, gif)</label>
            <input type="file" name="foto_deskripsi" id="foto_deskripsi" class="form-control" accept=".jpg,.jpeg,.png,.gif" required />
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan Lowongan</button>
    </form>
</div>

</body>
</html>
