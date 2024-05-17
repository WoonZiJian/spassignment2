<?php
// Database connection constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'spassignment1');

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        // Query to get the hashed password from the database
        $sql = "SELECT password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the email is in the database, verify the password
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = trim($row['password']);

            if (password_verify($password, $hashed_password)) {
                // Redirect to pizza order page upon successful login
                header("Location: pizza_order.php");
                exit;
            } else {
                $error_message = "Invalid credentials";
            }
        } else {
            $error_message = "Invalid credentials";
        }
    } else {
        $error_message = "Email and password must be provided.";
    }
}
?>

