<?php
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);

session_start();
session_regenerate_id(true);

$_SESSION = []; // Clear all session data

// Remove the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy(); 

header('Location: login.php');
exit();
?>
