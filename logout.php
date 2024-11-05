<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Optionally, remove the cookie
setcookie("user_login", "", time() - 3600, "/");

header('Location: index.php');
exit;
?>
