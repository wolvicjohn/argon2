<?php
// Database connection
$host = 'localhost';
$db = 'argon2_auth';
$user = 'root'; // Your database username
$pass = '';     // Your database password

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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f5f5f5;
        }

        input {
            margin: 10px 0;
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .password-strength {
            margin-top: 10px;
            height: 10px;
            width: 300px;
            background-color: #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease-in-out;
        }

        .strength-weak {
            background-color: red;
        }

        .strength-medium {
            background-color: orange;
        }

        .strength-strong {
            background-color: green;
        }

        .message {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
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

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            const strength = calculateStrength(password);
            updateStrengthMeter(strength);
        });

        function calculateStrength(password) {
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            return strength;
        }

        function updateStrengthMeter(strength) {
            // Reset the strength bar
            strengthBar.className = 'strength-bar';
            strengthBar.style.width = ${ strength * 20 }%;

            // Set the color and text based on strength
            if (strength <= 1) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Weak';
                strengthText.style.color = 'red';
            } else if (strength <= 3) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Medium';
                strengthText.style.color = 'orange';
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Strong';
                strengthText.style.color = 'green';
            }
        }
    </script>
</body>

</html>