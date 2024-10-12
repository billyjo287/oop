<?php
session_start();
require_once '../private/Database.php'; 
require_once '../private/User.php'; 

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        body {
            background-color: #343a40; 
            color: white; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-container {
            background-color: #212529; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            background-color: #495057;
            color: white;
            border: 1px solid #6c757d;
        }
        .form-control:focus {
            background-color: #495057;
            color: white;
            box-shadow: none;
            border-color: #80bdff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="otp-container">
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
