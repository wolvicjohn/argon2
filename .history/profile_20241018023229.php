<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
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

// Get the username from the session
$username = $_SESSION['username'];

// Fetch the user's details from the database
$stmt = $pdo->prepare('SELECT password_hash FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    // Handle the case where the user is not found
    echo "User not found.";
    exit;
}

// Store the hashed password
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
        <p>This is your profile page. You can update your details here.</p>

        <h3>User Details:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Password (plain):</strong> (not displayed for security reasons)</p>
        <p><strong>Password (hashed):</strong> <?php echo htmlspecialchars($hashedPassword); ?></p>

        <!-- Add more profile-related content here -->

        <a href="logout.php" class="button">Logout</a> <!-- Add a logout button -->
    </div>
</body>

</html>