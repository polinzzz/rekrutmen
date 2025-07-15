<?php
include 'koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: data_pelamar.php");
    exit;
}

$id = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM pelamar WHERE id = $id");
$pelamar = mysqli_fetch_assoc($query);

if (!$pelamar) {
    echo "Data tidak ditemukan.";
    exit;
}

if (isset($_POST['update'])) {
    $posisi_dilamar    = mysqli_real_escape_string($conn, $_POST['posisi_dilamar']);
    $email             = mysqli_real_escape_string($conn, $_POST['email']);
    $nik               = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama              = mysqli_real_escape_string($conn, $_POST['nama']);
    $tempat_lahir      = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir     = $_POST['tanggal_lahir'];
    $jk                = mysqli_real_escape_string($conn, $_POST['jk']);
    $agama             = mysqli_real_escape_string($conn, $_POST['agama']);
    $alamat            = mysqli_real_escape_string($conn, $_POST['alamat']);
    $status_pernikahan = mysqli_real_escape_string($conn, $_POST['status_pernikahan']);
    $kewarganegaraan   = mysqli_real_escape_string($conn, $_POST['kewarganegaraan']);

    $update = mysqli_query($conn, "UPDATE pelamar SET 
        posisi_dilamar='$posisi_dilamar', email='$email', nik='$nik', nama='$nama', 
        tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', jk='$jk', 
        agama='$agama', alamat='$alamat', status_pernikahan='$status_pernikahan', 
        kewarganegaraan='$kewarganegaraan'
        WHERE id=$id");

    if ($update) {
        header("Location: admin_dashboard.php?page=admin_dashboard_welcome.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Pelamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Edit Data Pelamar</h3>
    <form method="POST">
        <?php
        function inputText($label, $name, $value, $type = 'text') {
            echo "<div class='mb-2'>
                    <label>$label</label>
                    <input type='$type' name='$name' value='$value' class='form-control'>
                  </div>";
        }

        inputText('Posisi Dilamar', 'posisi_dilamar', $pelamar['posisi_dilamar']);
        inputText('Email', 'email', $pelamar['email'], 'email');
        inputText('NIK', 'nik', $pelamar['nik']);
        inputText('Nama', 'nama', $pelamar['nama']);
        inputText('Tempat Lahir', 'tempat_lahir', $pelamar['tempat_lahir']);
        inputText('Tanggal Lahir', 'tanggal_lahir', $pelamar['tanggal_lahir'], 'date');
        ?>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-control">
                <option value="Laki-laki" <?= $pelamar['jk'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= $pelamar['jk'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <?php
        inputText('Agama', 'agama', $pelamar['agama']);
        ?>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= $pelamar['alamat'] ?></textarea>
        </div>

        <?php
        inputText('Status Pernikahan', 'status_pernikahan', $pelamar['status_pernikahan']);
        inputText('Kewarganegaraan', 'kewarganegaraan', $pelamar['kewarganegaraan']);
        ?>

        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
