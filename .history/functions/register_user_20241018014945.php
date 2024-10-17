<?php
// register_user.php

include 'functionsconnection.php'; // Ensure to include the database connection
include 'hash.php';       // Include the hash function

/**
 * Registers a new user
 *
 * @param string $username The username to register
 * @param string $password The password to hash and store
 * @return string A message indicating the registration result
 */
function registerUser($username, $password) {
    global $pdo; // Access the $pdo variable from the global scope

    // Check if username exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return 'Username already taken';
    }

    // Hash password using the separate function
    $passwordHash = hashPassword($password);

    // Insert user into database
    $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
    $stmt->execute([$username, $passwordHash]);

    return "User registered successfully!";
}
?>
