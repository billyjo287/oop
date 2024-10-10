<?php
session_start();
require_once '../backhand/Database.php'; 
require_once '../backhand/User.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = htmlspecialchars(strip_tags($_POST['otp']));

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } else {
        die('No email in session. Please register first.');
    }

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    // Validate the OTP
    if ($user->validateOtp($email, $otp)) {
        if ($user->verifyUser($email)) {
            $_SESSION['verified'] = true;
            header('Location: login.php?verified=success');
            exit();
        } else {
            echo "Failed to verify user. Please try again.";
        }
    } else {
        echo "Invalid OTP. Please check and try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Verify OTP</h2>
    <form method="POST" action="verify_otp.php">
        <div class="mb-3">
            <label for="otp" class="form-label">Enter the provided OTP:</label>
            <input type="text" class="form-control" id="otp" name="otp" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
</div>
</body>
</html>
