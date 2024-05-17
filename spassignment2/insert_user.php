<?php
require_once 'config.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); 
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepared statement for SQL injection prevention
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);

        echo "User added successfully!";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Assuming 23000 is your error code for duplicates
            echo "Error: Username or email already exists";
        } else {
            echo "Error: " . $e->getMessage(); // For other database errors
        }
    }
} else {
    echo "Invalid request method";
}
?>
