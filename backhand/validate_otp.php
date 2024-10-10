<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $email = $_SESSION['email']; //To strore email during registration

    // To fetch user with matching email and OTP
    $sql = "SELECT * FROM users WHERE email='$email' AND otp='$otp' AND is_verified=0";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // If the otp is verified the user will be updated
        $update = "UPDATE users SET is_verified=1, otp=NULL WHERE email='$email'";
        if ($conn->query($update) === TRUE) {
            $_SESSION['verified'] = true;
            header("Location: ../public/login.php?verified=success");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid OTP.";
    }
}
?>
