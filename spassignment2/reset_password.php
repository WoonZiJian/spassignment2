<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'spassignment1');
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM users WHERE reset_token = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && hash_equals($user['reset_token'], $token_hash)) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Reset Password</title>
    </head>
    <body>
        <form action="process_reset.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="password_confirmation">Repeat Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <button type="submit">Change Password</button>
        </form>
    </body>
    </html>
    <?php
} else {
    echo "Invalid or expired token.";
}
?>
