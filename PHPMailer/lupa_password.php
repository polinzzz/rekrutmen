<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Cek apakah email terdaftar
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime('+10 minutes'));

        // Simpan OTP
        $stmt = $conn->prepare("UPDATE users SET otp = ?, otp_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $otp, $expiry, $email);
        $stmt->execute();

        // Kirim OTP
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'polin790@gmail.com';
            $mail->Password = 'addz qkvn xrui dneq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('polin790@gmail.com', 'Sistem Rekrutmen');
            $mail->addAddress($email);
            $mail->Subject = 'Kode OTP untuk Reset Password';
            $mail->Body = "Kode OTP Anda: $otp\nBerlaku selama 10 menit.";

            $mail->send();
            echo "<script>alert('OTP telah dikirim ke email Anda'); window.location='verifikasi_otp.php?email=$email';</script>";
        } catch (Exception $e) {
            echo "Gagal kirim email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan');</script>";
    }
}
?>

<!-- Form lupa password -->
<form method="POST">
    <h3>Lupa Password</h3>
    <input type="email" name="email" placeholder="Masukkan Email Anda" required>
    <button type="submit" name="submit">Kirim OTP</button>
</form>
