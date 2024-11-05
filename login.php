<?php
session_start();
require_once('db_config.php');
require_once('validate.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
        $error = "All fields are required!";
    } else {
        // Query database for user
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Optionally, set a cookie for auto-login (for a week)
                setcookie("user_login", $user['username'], time() + (86400 * 7), "/");

                // Redirect to dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
    </form>
    <p>If you don't have an account,<a href="register.php">Register here</a>.</p>
</body>
</html>
