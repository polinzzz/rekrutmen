<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function kirim_email($tujuan, $nama, $judul, $pesan) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi server
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'polinlumbantoruan790@gmail.com'; // Email pengirim
        $mail->Password   = 'bgyeotxjzneuwexe';   // APP Password Gmail tanpa spasi!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Penerima
        $mail->setFrom('polinlumbantoruan790@gmail.com', 'xampp'); // Harus sama dgn Username
        $mail->addAddress($tujuan, $nama);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = $judul;
        $mail->Body    = $pesan;

        $mail->send();
        
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}"; // Penting untuk tahu penyebab error
        return false;
    }
}
?>
