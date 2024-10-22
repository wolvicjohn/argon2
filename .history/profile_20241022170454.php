<?php
require 'db.php';
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection
require 'db.php';

// Get the username from the session
$username = $_SESSION['username'];

// Fetch the user's details from the database
$stmt = $pdo->prepare('SELECT password_hash, salt FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit;
}

$hashedPassword = $user['password_hash'];
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

        <h3>User Details:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Password (hashed):</strong></p>
        <textarea readonly><?php echo htmlspecialchars($hashedPassword); ?></textarea>

        <a href="logout.php" class="button">Logout</a>
    </div>
</body>

</html>