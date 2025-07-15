<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Pelamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('images/fotobg1.jpg') no-repeat center center/cover;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            background: rgba(255,255,255,0.95);
            animation: fadeIn 1s forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
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
        .alert-custom {
            font-size: 0.9rem;
            margin-top: -10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

       

<div class="container d-flex justify-content-center">
    <div class="card">
        <div class="text-center mb-3">
            <img src="images/logo1ABC.png" alt="Logo Perusahaan" class="logo" />
            <h3 class="fw-bold">Login Ujian Pelamar</h3>
            <p class="text-muted">Masukkan NIK dan Email Anda untuk login</p>
        </div>

        <!-- Pesan peringatan elegan -->
        <div class="alert alert-info text-center alert-custom" role="alert">
            <i class="bi bi-info-circle-fill text-primary me-1"></i>
            Pastikan Anda sudah mendaftar dan mengirim  lamaran sebelum mengikuti ujian.
        </div>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required />
            </div>
            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
