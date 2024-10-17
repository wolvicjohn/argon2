<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        input {
            margin: 10px 0;
            padding: 8px;
            width: 300px;
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
            background-color: yellow;
        }

        .strength-strong {
            background-color: green;
        }

        #strength-text {
            margin-top: 5px;
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
        <p id="strength-text"></p><br>

        <button type="submit">Register</button>
        <a href="login.php" class="button">Login account</a>
    </form>

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', () => {
            const strength = calculateStrength(passwordInput.value);
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