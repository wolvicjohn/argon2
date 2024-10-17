<?php
include 'functions/register_user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the register function
    $message = registerUser($username, $password);

    // Display the result message
    echo "<p style='text-align:center; color: green;'>$message</p>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>

<body>
    <div class="container">
        <div class="registration-box">
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

                <button type="submit">Register</button>
                <a href="login.php">Login account</a>
            </form>
        </div>
    </div>

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
            strengthBar.style.width = `${strength * 20}%`;

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