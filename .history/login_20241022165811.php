<?php
// Include the database connection
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch the stored password hash and salt for the user
    $stmt = $pdo->prepare('SELECT password_hash, salt FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Combine the password with the server-side pepper
        $pepperedPassword = hash_hmac('sha256', $password, PEPPER);
        // Concatenate the peppered password with the stored salt
        $saltedPassword = $pepperedPassword . $user['salt'];

        // Verify the final hash with the stored password hash
        if (password_verify($saltedPassword, $user['password_hash'])) {
            // Store the username in the session
            $_SESSION['username'] = $username;
            // Redirect to profile.php
            header('Location: profile.php');
            exit(); // Always exit after redirect
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
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

            <br><br>
            <a href="register.php" class="button">Register Account</a>

            <!-- Display error message if any -->
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
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
