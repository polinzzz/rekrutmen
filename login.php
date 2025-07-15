<?php
include 'koneksi.php';
session_start();

$loginError = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password_input = $_POST['password'];

    // Ambil user berdasarkan email saja
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password dengan hash
        if (password_verify($password_input, $user['password'])) {
            // Jika cocok, login berhasil
            $_SESSION['pelamar'] = $email;
            echo "<script>alert('Login berhasil!'); window.location='dashboard_pelamar.php';</script>";
        } else {
            // Password salah
            $loginError = "Email atau password salah.";
        }
    } else {
        // Email tidak ditemukan
        $loginError = "Email atau password salah.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lowongan Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('images/fotobg1.jpg') no-repeat center center/cover;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            animation: fadeIn 1s forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
    <div class="card">
        <div class="text-center mb-4">
            <img src="images/logo1ABC.png" alt="Logo Perusahaan" class="logo">
            <h3 class="fw-bold">Login Pelamar</h3>
            <p class="text-muted">Silakan login untuk melanjutkan</p>
        </div>
        <!-- Menampilkan pesan kesalahan login -->
        <?php if (!empty($loginError)) : ?>
            <div class="alert alert-danger text-center"><?= $loginError; ?></div>
        <?php endif; ?>
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
        <div class="text-center mt-3">
            <p>Belum punya akun? <a href="register.php" class="text-decoration-none">Register</a></p>
            <p>Lupa kata sandi? <a href="lupa_password2.php" class="text-decoration-none">Klik di sini</a></p>
        </div>
    </div>
</div>

</body>
</html>

