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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .register-container {
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
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #80bdff;
        }
    </style>
</head>
<body>

<div class="register-container">
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
    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
