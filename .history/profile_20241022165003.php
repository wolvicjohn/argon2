<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$host = 'localhost';
$db = 'argon2_auth';
$user = 'root';  // or your DB username
$pass = '';      // or your DB password

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the PEPPER constant is already defined
if (!defined('PEPPER')) {
    define('PEPPER', 'your_random_pepper_value');
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

// Store the hashed password and salt
$hashedPassword = $user['password_hash'];
$salt = $user['salt'];
$pepperedInfo = "(Not shown for security reasons)";
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
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

        <h3>User Details:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>

        <p><strong>Salt:</strong> <?php echo htmlspecialchars($salt); ?></p>

        <p><strong>Password (hashed):</strong></p>
        <textarea readonly><?php echo htmlspecialchars($hashedPassword); ?></textarea>

        <p><strong>Pepper:</strong> <?php echo $pepperedInfo; ?></p>

        <a href="logout.php" class="button">Logout</a>
    </div>
</body>

</html>