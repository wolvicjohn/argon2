<?php
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

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
$salt = $user['salt'];

// Define the pepper value
define('PEPPER', 'pares-overload'); // Ensure this is a secure value
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

        <p><strong>Salt:</strong></p>
        <textarea readonly><?php echo htmlspecialchars($salt); ?></textarea>

        <p><strong>Pepper:</strong> <?php echo htmlspecialchars(PEPPER); ?></p> <!-- Display the pepper securely -->

        <a href="logout.php" class="button">Logout</a>
    </div>
</body>

</html>