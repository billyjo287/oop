<?php
session_start();
require_once '../backhand/Database.php';
require_once '../backhand/User.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    // Query to fetch the user details from the database
    $query = "SELECT * FROM users WHERE username = :username AND is_verified = 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data && password_verify($password, $user_data['password'])) {
        $_SESSION['username'] = $user_data['username'];
        header("Location: index.php");  
        exit();
    } else {
        $error_message = "Invalid username or password, or account not verified.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
