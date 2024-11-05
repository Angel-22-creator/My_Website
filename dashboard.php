<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}

// Optional: You can retrieve user-specific data from the database if needed.
require_once('db_config.php');
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <p><strong>Account Information:</strong></p>
    <ul>
        <li><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
        <li><strong>Account Created on:</strong> <?php echo date('F j, Y, g:i a', strtotime($user['created_at'])); ?></li>
    </ul>

    <h2>Your Shopping Cart:</h2>
    <ul>
        <?php
        // Check if there's anything in the session cart
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            echo "<ul>";
            foreach ($_SESSION['cart'] as $product_id) {
                // Here, normally we would fetch product details from a database.
                echo "<li>Product ID: $product_id</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
    </ul>

    <h2>Manage Your Account</h2>
    <p><a href="update_profile.php">Update Profile</a></p>
    <p><a href="change_password.php">Change Password</a></p>

    <hr>
    <a href="logout.php">Logout</a>
</body>
</html>
