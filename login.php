<?php
// Start the session
session_start();

define('PEPPER', 'your_random_pepper_value');

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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the salt and password hash from the database
    $stmt = $pdo->prepare('SELECT password_hash, salt FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $pepperedPassword = hash_hmac('sha256', $password, PEPPER);
        $hashedPassword = $pepperedPassword . $user['salt'];

        // Verify the password
        if (password_verify($hashedPassword, $user['password_hash'])) {
            // Store user information in the session
            $_SESSION['username'] = $username;

            // Redirect to profile.php
            header('Location: profile.php');
            exit(); // Always call exit() after a redirect
        } else {
            echo 'Invalid username or password.';
        }
    } else {
        echo 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Login</button>

            <br>

            <!-- Button to go to the registration page -->
            <a href="register.php" class="button">Register Account</a>
        </form>
    </div>

    <script>
        // Add a class to the body when the page has loaded
        window.addEventListener('load', function () {
            document.body.classList.add('loaded');
        });
    </script>
</body>

</html>
