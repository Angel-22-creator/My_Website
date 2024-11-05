<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Connect to the database
require_once('db_config.php');
$user_id = $_SESSION['user_id'];

// Fetch current user details from the database
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate user input
    $new_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $new_username = trim($_POST['username']);

    // Validate the email
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Update the user's details in the database
        $update_sql = "UPDATE users SET email = '$new_email', username = '$new_username' WHERE id = $user_id";
        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['message'] = 'Profile updated successfully!';
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Failed to update profile: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>
<body>
    <h1>Update Your Profile</h1>
    
    <!-- Display error message if any -->
    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    if (isset($_SESSION['message'])) {
        echo "<p style='color:green;'>".$_SESSION['message']."</p>";
        unset($_SESSION['message']); // Clear the message after displaying
    }
    ?>
    
    <!-- Profile update form -->
    <form action="update_profile.php" method="POST">
        <label for="username">New Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

        <label for="email">New Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <input type="submit" value="Update Profile">
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
