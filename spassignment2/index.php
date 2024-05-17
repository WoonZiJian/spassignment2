<?php
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();
session_regenerate_id(true);

require 'database_connection.php';
require 'login.php';

// IF USER LOGGED IN
if (isset($_SESSION['user_email'])) {
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css" media="all" type="text/css">
</head>
<body>
    <form action="" method="post">
        <h2>Login Page</h2>
        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter email" id="email" name="email" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter password" id="password" name="password" required>

            <button type="submit">Login</button>
            <small class="link">
                <a href="forgot_password.php">Forgot password?</a>
            </small>
        </div>
        <?php
        if (isset($success_message)) {
            echo '<div class="success_message">' . $success_message . '</div>';
        }
        if (isset($error_message)) {
            echo '<div class="error_message">' . $error_message . '</div>';
        }
        ?>
        <div class="registration-form-container">
            <a href="register.php"><button type="button" class="Regbtn">Create an account</button></a>
        </div>
    </form>
</body>
</html>
