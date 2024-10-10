<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/PHPMailer/src/Exception.php'; 
require '../src/PHPMailer/src/PHPMailer.php'; 
require '../src/PHPMailer/src/SMTP.php'; 

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'igiranezabilly400@gmail.com'; 
        $mail->Password = 'billyjohn123@'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // The Recipient
        $mail->setFrom('your_email@gmail.com', 'Your Name'); // Update as needed
        $mail->addAddress($email); // Add recipient

        // The Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: <b>$otp</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // If the email fails, it returns false 
        return false; 
    }
}
?>
