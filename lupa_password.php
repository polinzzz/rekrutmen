<?php
include 'koneksi.php';
require 'kirim_email.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {
        $token = bin2hex(random_bytes(32));
        $token_expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        mysqli_query($conn, "UPDATE users SET token='$token', token_expiry='$token_expiry' WHERE email='$email'");

        $link = "http://localhost/recruitment/ganti_password.php?email=$email&token=$token";
        $pesan = "Klik link berikut untuk mengganti password Anda:<br><a href='$link'>Ganti Password</a>";

        if (kirim_email($email, "Pengguna", "Reset Password", $pesan)) {
            echo "Link perubahan password sudah dikirimkan ke email Anda.";
        } else {
            echo "Gagal mengirim email.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}
?>
