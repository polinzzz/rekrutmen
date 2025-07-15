<?php
include 'koneksi.php';
$email = $_GET['email'];

if (isset($_POST['verify'])) {
    $otp = $_POST['otp'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp = ? AND otp_expiry >= NOW()");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('OTP valid'); window.location='reset_password.php?email=$email';</script>";
    } else {
        echo "<script>alert('OTP salah atau kadaluarsa');</script>";
    }
}
?>

<!-- Form OTP -->
<form method="POST">
    <h3>Verifikasi OTP</h3>
    <input type="text" name="otp" maxlength="6" required placeholder="Masukkan 6 digit OTP">
    <button type="submit" name="verify">Verifikasi</button>
</form>
