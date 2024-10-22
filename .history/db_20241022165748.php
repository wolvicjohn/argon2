<?php
// Start the session
session_start();

// Define the pepper as a server-side constant
define('PEPPER', 'pares-overload'); 

// Database connection details
$host = 'localhost';
$db = 'argon2_auth';
$user = 'root';  // Update with your database username if needed
$pass = '';      // Update with your database password if needed

// Database connection options
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
?>
