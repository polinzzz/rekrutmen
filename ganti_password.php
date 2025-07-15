<?php
require 'koneksi.php'; // koneksi ke database

$pesan = '';
$berhasil = false;

if (!isset($_GET['token'])) {
    $pesan = "Token tidak ditemukan.";
} else {
    $token = $_GET['token'];

    // Ambil user berdasarkan token
    $stmt = $conn->prepare("SELECT id FROM users WHERE token_ganti_password = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $pesan = "Token tidak valid atau sudah digunakan.";
    } else {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password_baru = trim($_POST['password']);

            if (strlen($password_baru) < 6) {
                $pesan = "Password harus minimal 6 karakter.";
            } else {
                // Menggunakan hash yang aman
                $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

                // Update password & hapus token
                $update = $conn->prepare("UPDATE users SET password = ?, token_ganti_password = NULL WHERE id = ?");
                $update->bind_param("si", $password_hash, $user_id);

                if ($update->execute()) {
                    $pesan = "✅ Password berhasil diperbarui.";
                    $berhasil = true;
                } else {
                    $pesan = "❌ Gagal memperbarui password: " . $conn->error;
                }
                $update->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            padding: 30px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button, a.button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }
        .message {
            margin-bottom: 20px;
            color: #444;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>

    <?php if (!empty($pesan)): ?>
        <div class="message"><?= $pesan ?></div>
    <?php endif; ?>

    <?php if ($berhasil): ?>
        <a href="login.php" class="button">Kembali ke Menu Login</a>
    <?php else: ?>
        <form method="POST">
            <label for="password">Password Baru:</label><br>
            <input type="password" name="password" id="password" required><br>
            <button type="submit">Ganti Password</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
