<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'spassignment1');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$sql = "UPDATE users
        SET reset_token = ?,
            reset_token_expiry = ?
        WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("woonjian@graduate.utm.my");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END
    Click <a href="http://localhost/spassignment1/reset_password.php?token=$token">here</a> 
    to reset your password.
    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
}

echo "Message sent, please check your inbox.";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form>
        <h2>Password Reset</h2>
        <div class="container">
            <div class="success_message">If the email exists, a password reset link has been sent to your email address.</div>
            <button type="button" onclick="window.location.href='index.php'">Back to Homepage</button>
        </div>
    </form>
</body>
</html>

