<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Registration Form</h2>
    <form action="insert_user.php" method="post">
        <div class="container">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register" class="Regbtn">
        </div>
    </form>
</body>
</html>

