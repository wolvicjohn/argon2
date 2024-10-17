<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username is already taken
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        die('Username is already taken');
    }

    // Hash the password using Argon2
    $passwordHash = password_hash($password, PASSWORD_ARGON2ID);

    // Insert the new user into the database
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
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f0f0f5;
        }

        input {
            margin: 10px 0;
            padding: 8px;
            width: 300px;
        }

        button {
            padding: 8px 16px;
            margin-top: 10px;
            cursor: pointer;
        }

        .password-strength {
            margin-top: 10px;
            height: 10px;
            width: 300px;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s;
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
    </style>
</head>

<body>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>

        <!-- Password Strength Meter -->
        <div class="password-strength">
            <div class="strength-bar" id="strength-bar"></div>
        </div>
        <p id="strength-text"></p><br>

        <button type="submit">Register</button>
        <a href="login.php" class="button">Login account</a>
    </form>

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', () => {
            console.log(passwordInput.value); // Debugging: Check input capture
            const strength = calculateStrength(passwordInput.value);
            updateStrengthMeter(strength);
        });

        function calculateStrength(password) {
            let strength = 0;

            // Criteria for password strength
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            return strength;
        }

        function updateStrengthMeter(strength) {
            strengthBar.className = '';  // Reset bar style

            if (strength <= 1) {
                strengthBar.style.width = '20%';
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Weak';
            } else if (strength <= 3) {
                strengthBar.style.width = '60%';
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Medium';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Strong';
            }
        }
    </script>
</body>

</html>
