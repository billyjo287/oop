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
