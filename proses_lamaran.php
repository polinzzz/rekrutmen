<?php
session_start();
if (!isset($_SESSION['pelamar'])) {
    header("Location: login.php");
    exit;
}

include 'admin/koneksi.php'; // Pastikan path ini benar

// Folder upload
$folder = 'uploads/';

// Pastikan folder ada
if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}

// Fungsi upload file dengan pengecekan
function upload_dokumen($field, $folder) {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
        $name = basename($_FILES[$field]['name']);
        $tmp = $_FILES[$field]['tmp_name'];
        $target = $folder . $name;
        if (move_uploaded_file($tmp, $target)) {
            return $name;
        } else {
            return null; // Gagal upload
        }
    }
    return null; // Tidak ada file
}

// Ambil data dari form dengan sanitasi sederhana
$posisi = $_POST['posisi_dilamar'] ?? '';
$nik = $_POST['nik'] ?? '';
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$jk = $_POST['jk'] ?? '';
$status_pernikahan = $_POST['status_pernikahan'] ?? '';
$kewarganegaraan = $_POST['kewarganegaraan'] ?? '';
$alamat = $_POST['alamat'] ?? '';

// Upload foto diri
$foto = upload_dokumen('foto', $folder);

// Simpan ke tabel pelamar
$query = "INSERT INTO pelamar (posisi_dilamar, nik, nama, email, tempat_lahir, tanggal_lahir, jk, status_pernikahan, kewarganegaraan, alamat, foto) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare pelamar failed: " . $conn->error);
}
$stmt->bind_param("sssssssssss", $posisi, $nik, $nama, $email, $tempat_lahir, $tanggal_lahir, $jk, $status_pernikahan, $kewarganegaraan, $alamat, $foto);
if (!$stmt->execute()) {
    die("Execute pelamar failed: " . $stmt->error);
}
$pelamar_id = $stmt->insert_id; // Ambil ID terakhir

// Simpan ke tabel pendidikan
$jenjang = $_POST['jenjang'] ?? '';
$instansi = $_POST['instansi'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$ipk = $_POST['ipk'] ?? '';
$tahun_masuk = $_POST['tahun_masuk'] ?? 0;
$tahun_keluar = $_POST['tahun_keluar'] ?? 0;

$query_pendidikan = "INSERT INTO pendidikan (pelamar_id, jenjang, instansi, jurusan, ipk, tahun_masuk, tahun_keluar) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query_pendidikan);
if (!$stmt) {
    die("Prepare pendidikan failed: " . $conn->error);
}
$stmt->bind_param("issssii", $pelamar_id, $jenjang, $instansi, $jurusan, $ipk, $tahun_masuk, $tahun_keluar);
if (!$stmt->execute()) {
    die("Execute pendidikan failed: " . $stmt->error);
}

// Simpan ke tabel pengalaman kerja
$nama_perusahaan = $_POST['nama_perusahaan'] ?? '';
$tahun_masuk_kerja = $_POST['tahun_masuk_kerja'] ?? 0;
$tahun_keluar_kerja = $_POST['tahun_keluar_kerja'] ?? 0;
$gaji_sebelumnya = $_POST['gaji_sebelumnya'] ?? 0;
$alasan_keluar = $_POST['alasan_keluar'] ?? '';

$query_pengalaman = "INSERT INTO pengalaman_kerja (pelamar_id, nama_perusahaan, tahun_masuk, tahun_keluar, gaji_sebelumnya, alasan_keluar) 
                     VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query_pengalaman);
if (!$stmt) {
    die("Prepare pengalaman failed: " . $conn->error);
}
$stmt->bind_param("ississ", $pelamar_id, $nama_perusahaan, $tahun_masuk_kerja, $tahun_keluar_kerja, $gaji_sebelumnya, $alasan_keluar);
if (!$stmt->execute()) {
    die("Execute pengalaman failed: " . $stmt->error);
}

// Upload dan simpan dokumen pendukung
$foto_ktp    = upload_dokumen('foto_ktp', $folder);
$ijazah      = upload_dokumen('ijazah', $folder);
$transkrip   = upload_dokumen('transkrip', $folder);
$sertifikat  = upload_dokumen('sertifikat', $folder);
$skck        = upload_dokumen('skck', $folder);
$npwp        = upload_dokumen('npwp', $folder);
$vaksin1     = upload_dokumen('vaksin1', $folder);
$vaksin2     = upload_dokumen('vaksin2', $folder);

// Periksa tabel dokumen_pendukung ada atau tidak
$check_table = $conn->query("SHOW TABLES LIKE 'dokumen_pendukung'");
if ($check_table->num_rows == 0) {
    die("Tabel dokumen_pendukung belum ada di database.");
}

$query_dokumen = "INSERT INTO dokumen_pendukung (pelamar_id, foto_ktp, ijazah, transkrip, sertifikat, skck, npwp, vaksin1, vaksin2)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query_dokumen);
if (!$stmt) {
    die("Prepare dokumen_pendukung failed: " . $conn->error);
}
$stmt->bind_param("issssssss", $pelamar_id, $foto_ktp, $ijazah, $transkrip, $sertifikat, $skck, $npwp, $vaksin1, $vaksin2);
if (!$stmt->execute()) {
    die("Execute dokumen_pendukung failed: " . $stmt->error);
}

// Redirect ke halaman sukses
header("Location: dashboard_pelamar.php?status=sukses");
exit;
?>
