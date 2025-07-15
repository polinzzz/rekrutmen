<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Silakan login dahulu.'); window.location='admin_login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .sidebar {
            height: 100vh;
            background-color: #0d6efd;
            padding-top: 30px;
            position: fixed;
            width: 250px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            font-weight: 500;
            transition: background 0.3s ease;
            cursor: pointer;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #0b5ed7;
            border-left: 5px solid #fff;
        }
        .content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            background-color: #fff;
        }
        .logout-btn {
            width: 100%;
            padding: 20px;
            text-align: center;
        }
        .logout-btn button {
            width: 80%;
            font-weight: 600;
        }
        hr {
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: 10px 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .content {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div>
        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="logo1ABC.png" alt="Logo" style="max-width: 120px; height: auto;">
        </div>
        <h4 class="text-center mb-4">Admin</h4>
        <hr>
        <a href="javascript:void(0);" class="nav-link active" onclick="loadPage('admin_dashboard_welcome.php', this)">Dashboard</a>
        <a href="javascript:void(0);" class="nav-link" onclick="loadPage('admin_lowongan.php', this)">Kelola Lowongan</a>
        <a href="javascript:void(0);" class="nav-link" onclick="loadPage('data_pelamar.php', this)">Data Pelamar</a>
        <a href="javascript:void(0);" class="nav-link" onclick="loadPage('ujian_pelamar_admin.php', this)">Ujian Pelamar</a>
        <a href="javascript:void(0);" class="nav-link" onclick="loadPage('admin_nilai.php', this)">Hasil Ujian Pelamar</a>
        <a href="javascript:void(0);" class="nav-link" onclick="loadPage('pengumuman.php', this)">Pengumuman</a>
    </div>

    <form action="logout.php" method="POST" class="logout-btn">
        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
    </form>
</div>

<!-- Konten Dinamis --> 
<div class="content" id="main-content">
    <!-- Default halaman selamat datang -->
    <h2 class="fw-bold">Selamat Datang, Admin</h2>
    <p class="text-muted">Gunakan menu di samping untuk mengelola data lowongan kerja, data pelamar, dan pengaturan akun Anda.</p>
</div>

<script>
function loadPage(page, el) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", page, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("main-content").innerHTML = xhr.responseText;

            // Hilangkan semua kelas active
            document.querySelectorAll('.nav-link').forEach(a => a.classList.remove('active'));
            // Tambahkan kelas active pada elemen saat ini
            if (el) el.classList.add('active');
        }
    };
    xhr.send();
}

// Load halaman default (admin_dashboard_welcome.php) dan set menu active default
window.onload = function() {
    // Cari menu yang sudah active
    let activeMenu = document.querySelector('.nav-link.active');
    if (!activeMenu) {
        activeMenu = document.querySelector('.nav-link'); // fallback ke menu pertama
        if(activeMenu) activeMenu.classList.add('active');
    }
    if (activeMenu) {
        // Load halaman sesuai menu aktif
        const page = activeMenu.getAttribute('onclick').match(/'(.*?)'/)[1];
        loadPage(page, activeMenu);
    }
};
</script>

</body>
</html>
