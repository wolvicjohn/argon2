<?php
// authenticate_user.php
include 'connection.php'; // Include the database connection

/**
 * Authenticate a user
 *
 * @param string $username The username to authenticate
 * @param string $password The password to verify
 * @return string A message indicating the result of the authentication
 */
function authenticateUser($username, $password) {
    global $pdo; // Access the PDO instance

    // Find the user in the database
    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Password is correct, handle successful login
        return "Login successful! Welcome, " . htmlspecialchars($username);
    } else {
        // Invalid credentials
        return "Invalid username or password.";
    }
}
?>
