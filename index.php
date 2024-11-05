<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store</title>
</head>
<body>
    <h1>Welcome to our Clothing Store</h1>
    <?php
    if (isset($_SESSION['user_id'])) {
        echo "Welcome " . $_SESSION['username'] . "!";
        echo "<a href='logout.php'>Logout</a>";
    } else {
        echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
    }
    ?>
</body>
</html>
