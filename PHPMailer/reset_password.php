<?php
include 'koneksi.php';
$email = $_GET['email'];

if (isset($_POST['reset'])) {
    $password_baru = $_POST['password'];
    
    $stmt = $conn->prepare("UPDATE users SET password = ?, otp = NULL, otp_expiry = NULL WHERE email = ?");
    $stmt->bind_param("ss", $password_baru, $email);
    $stmt->execute();

    echo "<script>alert('Password berhasil diubah'); window.location='login.php';</script>";
}
?>

<!-- Form reset password -->
<form method="POST">
    <h3>Reset Password</h3>
    <input type="password" name="password" required placeholder="Password Baru">
    <button type="submit" name="reset">Simpan Password</button>
</form>
