<?php
session_start();

$admin_email = "admin@35.com";  // Email admin yang hardcoded
$admin_password = "admin123";   // Password admin yang hardcoded

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email dan password yang dimasukkan sesuai dengan admin yang telah ditentukan
    if ($email === $admin_email && $password === $admin_password) {
        // Simpan session dengan key 'admin' agar sesuai dengan pengecekan di halaman lain
        $_SESSION['admin'] = true;
        $_SESSION['email'] = $email;  // Simpan juga email jika diperlukan

        echo "<script>alert('Login berhasil sebagai Admin!'); window.location='admin_dashboard.php';</script>";
        exit;  // Pastikan script berhenti setelah redirect
    } else {
        echo "<script>alert('Email atau Password salah');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Lowongan Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('fotobg1.jpg') no-repeat center center/cover;
        font-family: 'Poppins', sans-serif;
    }

    .card-wrapper {
        position: relative;
        padding: 5px; /* Ketebalan border */
        border-radius: 20px;
        background: linear-gradient(45deg, red, blue, red, blue); /* Warna border */
        background-size: 300% 300%;
        animation: rotateBorder 4s linear infinite;
        width: 100%;
        max-width: 420px;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 30px;
        width: 100%;
        height: 100%;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        opacity: 0;
        animation: fadeIn 1s forwards;
    }

    @keyframes rotateBorder {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    .form-label {
        font-weight: 600;
    }

    .btn-primary {
        font-weight: 600;
    }

    .logo {
        width: 100px;
        margin-bottom: 20px;
    }
    </style>

</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="card-wrapper">
        <div class="card">
            <div class="text-center mb-4">
                <img src="logo1ABC.png" alt="Logo Perusahaan" class="logo">
                <h3 class="fw-bold">Login Admin</h3>
                <p class="text-muted">Silakan login untuk melanjutkan</p>
            </div>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Gmail (Email)</label>
                    <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

</body>
</html>
