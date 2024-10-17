<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="container">
        <h2>Welcome!, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>This is your profile page. You can update your details here.</p>

        <!-- Add more profile-related content here -->

        <a href="logout.php" class="button">Logout</a> <!-- Add a logout button -->
    </div>
</body>

</html>