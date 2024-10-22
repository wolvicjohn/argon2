<?php
// Include the database connection
require 'db.php';

$message = ''; 
define('PEPPER', 'your_random_pepper_value');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        $message = '<div class="message error">Username already taken</div>';
    } else {
        // Generate a random salt
        $salt = bin2hex(random_bytes(16));

        // Add pepper (constant secret value)
        $pepperedPassword = hash_hmac('balut', $password, PEPPER);

        // Combine password, salt, and pepper before hashing
        $passwordHash = password_hash($pepperedPassword . $salt, PASSWORD_ARGON2ID);

        // Insert user into the database with the salt and hashed password
        $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, salt) VALUES (?, ?, ?)');
        $stmt->execute([$username, $passwordHash, $salt]);

        $message = '<div class="message success">User registered successfully!</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
</head>

<body>
    <div class="container"> <!-- Container for centering -->
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <div class="password-strength">
                <div class="strength-bar" id="strength-bar"></div>
            </div>
            <p class="message" id="strength-text">Enter a password</p>

            <?php if ($message): ?>
                <?= $message; ?> <!-- Display the message -->
            <?php endif; ?>

            <button type="submit">Register</button>
            <a href="login.php">Login account</a>
        </form>
    </div>

    <script src="script.js"></script> <!-- Link to external JS -->
</body>

</html>