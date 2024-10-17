<?php
// Include the database connection
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        die('Username already taken');
    }

    // Hash password with Argon2
    $passwordHash = password_hash($password, PASSWORD_ARGON2ID);

    // Insert user into database
    $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
    $stmt->execute([$username, $passwordHash]);

    echo "User registered successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>

        <div class="password-strength">
            <div class="strength-bar" id="strength-bar"></div>
        </div>
        <p class="message" id="strength-text">Enter a password</p><br>

        <button type="submit">Register</button>
        <a href="login.php">Login account</a>
    </form>

    <script src="script.js"></script> <!-- Link to external JS -->
</body>

</html>