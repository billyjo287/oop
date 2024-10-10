<?php
session_start();
require_once '../backhand/Database.php';
require_once '../backhand/User.php';
require_once '../backhand/send-otp.php'; 


$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // To check if the password in the password field and the password in the confirm password field matches
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error_message = "Passwords do not match!";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);

        $username = htmlspecialchars(strip_tags($_POST['username']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $otp = rand(000000, 999999); //To generate a 6 digits random number between 000000 and 999999

        // To create a user
        if ($user->create($username, $email, $password, $otp)) {
            // Send OTP
            if (sendOTP($email, $otp)) {
                $_SESSION['email'] = $email;
                header("Location: verify_otp.php");
                exit();
            } else {
                $error_message = "Failed to send OTP. Please try again.";
            }
        } else {
            $error_message = "Email already registered or error creating user.";
        }   
             
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Register</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="register.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
