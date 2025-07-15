<h3 style="text-align:center; font-family:sans-serif; color:#2c3e50;">🔐 Lupa Password</h3>

<?php
session_start();
include('koneksi.php'); 
include('kirim_email.php');

function url_dasar() {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
    $url .= "://" . $_SERVER['HTTP_HOST'];
    $url .= dirname($_SERVER['PHP_SELF']);
    return rtrim($url, '/');
}

if (isset($_SESSION['users_email']) && $_SESSION['users_email'] != '') {
    header("Location: dashboard_pelamar.php");
    exit();
}

$err = "";
$sukses = "";
$email = "";

if (isset($_POST['submit'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if ($email == '') {
        $err = "Silakan masukkan email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = "Format email tidak valid.";
    } else {
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $sql1 = "SELECT * FROM users WHERE email = '$email_escaped'";
        $q1 = mysqli_query($conn, $sql1);
        $n1 = mysqli_num_rows($q1);

        if ($n1 < 1) {
            $err = "Email <b>$email</b> tidak ditemukan.";
        }
    }

    if (empty($err)) {
        $token_ganti_password = md5(rand(0, 1000)) . time();
        $judul_email = "Ganti Password";
        $isi_email = "Anda ingin melakukan perubahan password.<br><br>";
        $isi_email .= "Klik link di bawah untuk mengganti password Anda:<br>";
        $isi_email .= "<a href='" . url_dasar() . "/ganti_password.php?token=$token_ganti_password'>Klik di sini untuk mengganti password</a>";

        $berhasil_kirim = kirim_email($email, $email, $judul_email, $isi_email);

        if ($berhasil_kirim) {
            $sql2 = "UPDATE users SET token_ganti_password = '$token_ganti_password' WHERE email = '$email_escaped'";
            mysqli_query($conn, $sql2);
            $sukses = "✅ Link ganti password telah dikirim ke email Anda.";
        } else {
            $err = "❌ Gagal mengirim email. Coba lagi nanti.";
        }
    }
}
?>

<style>
    body {
        margin: 0;
        padding: 0;
        background: url('images/fotobg1.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
        background-color: rgba(255, 255, 255, 0.95);
        max-width: 420px;
        margin: 80px auto;
        padding: 30px 40px;
        border-radius: 16px;
        box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.25);
        text-align: center;
    }

    .form-wrapper h3 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 24px;
    }

    .input {
        width: 100%;
        padding: 12px;
        margin-top: 12px;
        margin-bottom: 18px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .tbl-biru, .btn-kembali {
        background-color: #2980b9;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        text-decoration: none;
        margin-top: 8px;
        display: inline-block;
    }

    .tbl-biru:hover, .btn-kembali:hover {
        background-color: #3498db;
    }

    .message {
        margin-bottom: 15px;
        font-weight: bold;
        font-size: 14px;
    }

    .message.error {
        color: red;
    }

    .message.success {
        color: green;
    }
</style>

<div class="form-wrapper">
    <h3>🔐 Lupa Password</h3>

    <?php if ($err) { echo "<div class='message error'>$err</div>"; } ?>
    <?php if ($sukses) { echo "<div class='message success'>$sukses</div>"; } ?>

    <form action="" method="POST">
        <input type="text" name="email" class="input" placeholder="Masukkan email Anda" value="<?php echo htmlspecialchars($email); ?>">
        <input type="submit" name="submit" value="Kirim Link Reset" class="tbl-biru"/>
    </form>

    <a href="login.php" class="btn-kembali">🔙 Kembali ke Menu Login</a>
</div>
