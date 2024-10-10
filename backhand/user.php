<?php

require 'Database.php';

class User {
    private $conn;
    private $table_name = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // To Create user
    public function create($username, $email, $password, $otp) {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password, otp) VALUES (:username, :email, :password, :otp)";
        $stmt = $this->conn->prepare($query);

        // To sanitize
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));
        $password = htmlspecialchars(strip_tags($password));
        $otp = htmlspecialchars(strip_tags($otp));

        // To bind values
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':otp', $otp);

        // To execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // To Validate OTP
    public function validateOtp($email, $otp) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email AND otp = :otp AND is_verified = 0";
        $stmt = $this->conn->prepare($query);

        // To sanitize
        $email = htmlspecialchars(strip_tags($email));
        $otp = htmlspecialchars(strip_tags($otp));

        // To bind values
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':otp', $otp);

        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Updating user to verified state
    public function verifyUser($email) {
        $query = "UPDATE " . $this->table_name . " SET is_verified = 1, otp = NULL WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // To sanitize
        $email = htmlspecialchars(strip_tags($email));

        // To bind values
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
