<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // ✅ Enkripsi password
    $no_hp = $_POST['no_hp'];
    $pendidikan = $_POST['pendidikan'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO users (nama_lengkap, email, password, no_hp, pendidikan, alamat) 
              VALUES ('$nama_lengkap', '$email', '$password', '$no_hp', '$pendidikan', '$alamat')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lowongan Kerja</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: url('images/fotobg1.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 40px 15px;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0px 8px 24px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 450px;
            padding: 40px 30px;
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            0% {opacity: 0; transform: translateY(30px);}
            100% {opacity: 1; transform: translateY(0);}
        }
        .form-label {
            font-weight: 600;
            font-size: 14px;
        }
        .btn-primary {
            font-weight: 600;
            font-size: 16px;
            padding: 10px;
            border-radius: 10px;
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        h3 {
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 5px;
        }
        p.text-muted {
            font-size: 14px;
            margin-bottom: 30px;
        }
        .small-link {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <div class="mb-4">
        <img src="images/logo1ABC.png" alt="Logo Perusahaan" class="logo">
        <h3>Form Registrasi</h3>
        <p class="text-muted">Daftar akun untuk melamar pekerjaan</p>
    </div>
    <form method="POST" action="">
        <div class="mb-3 text-start">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Gmail (Email)</label>
            <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">No. Handphone</label>
            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Pendidikan Terakhir</label>
            <select name="pendidikan" class="form-select" required>
                <option value="">-- Pilih Pendidikan --</option>
                <option value="SMA/SMK">SMA/SMK</option>
                <option value="D3">D3</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
            </select>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Alamat Domisili</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat" required></textarea>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </div>
    </form>
    <div class="text-center mt-3 small-link">
        <p>Sudah punya akun? <a href="login.php" class="text-decoration-none">Login</a></p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
