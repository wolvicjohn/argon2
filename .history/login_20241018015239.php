<?php
// Include the user authentication logic
include 'authenticate_user.php';

$message = ''; // Variable to hold the login message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the authenticate function
    $message = authenticateUser($username, $password);
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

        <?php if ($message): ?>
            <p style="text-align:center; color: <?php echo strpos($message, 'Invalid') !== false ? 'red' : 'green'; ?>;">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>
    </div>

    <script>
        // Add a class to the body when the page has loaded
        window.addEventListener('load', function () {
            document.body.classList.add('loaded');
        });
    </script>
</body>

</html>
