<?php
// Include the database connection
require 'db.php';

// Initialize message variable
$message = '';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        $message = '<div class="message error">Username already taken</div>';
    } else {
        // Generate a random salt (16 bytes)
        $salt = bin2hex(random_bytes(16));

        // Combine password with salt and pepper
        $pepperedPassword = hash_hmac('sha256', $password, PEPPER);
        $saltedPassword = $pepperedPassword . $salt;

        // Hash the final password using Argon2ID
        $passwordHash = password_hash($saltedPassword, PASSWORD_ARGON2ID);

        // Insert user into the database with salt
        $stmt = $pdo->prepare(
            'INSERT INTO users (username, password_hash, salt) VALUES (?, ?, ?)'
        );
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
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required oninput="checkPasswordStrength()">

            <div class="password-strength">
                <div class="strength-bar" id="strength-bar"></div>
            </div>
            <p class="message" id="strength-text">Enter a password</p>

            <?php if ($message): ?>
                <?= $message; ?>
            <?php endif; ?>

            <button type="submit">Register</button>
            <a href="login.php">Login account</a>
        </form>
    </div>

    <script src="script.js"></script>
    <script>
        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');

            let strength = 0;

            // Check password length
            if (password.length >= 8) strength += 1;
            // Check for numbers
            if (/\d/.test(password)) strength += 1;
            // Check for uppercase letters
            if (/[A-Z]/.test(password)) strength += 1;
            // Check for special characters
            if (/[\W_]/.test(password)) strength += 1;

            // Update strength bar and text based on strength
            strengthBar.style.width = (strength * 25) + '%';

            switch (strength) {
                case 0:
                    strengthText.textContent = 'Enter a password';
                    break;
                case 1:
                    strengthText.textContent = 'Weak';
                    break;
                case 2:
                    strengthText.textContent = 'Fair';
                    break;
                case 3:
                    strengthText.textContent = 'Good';
                    break;
                case 4:
                    strengthText.textContent = 'Strong';
                    break;
            }
        }
    </script>
</body>

</html>
