<?php
require 'database_connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form action="send_reset.php" method="POST">
        <h2>Forgot Password</h2>
        <div class="container">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Reset Password</button>
        </div>
    </form>
</body>
</html>

