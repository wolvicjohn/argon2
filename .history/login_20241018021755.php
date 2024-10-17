<?php
// Include the user authentication logic
include 'functions/authenticate_user.php';

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef; /* Light background for contrast */
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full viewport height */
        }

        .registration-box {
            background-color: #ffffff; /* White background for the box */
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            padding: 30px; /* Inner padding */
            width: 100%;
            max-width: 400px; /* Max width for the box */
            text-align: center; /* Center text */
            transition: transform 0.2s ease; /* Animation for hover effect */
        }

        .registration-box:hover {
            transform: scale(1.02); /* Slightly scale up on hover */
        }

        h2 {
            color: #333;
            margin-bottom: 20px; /* Space below heading */
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block; /* Block display for labels */
            color: #555; /* Slightly darker color for better contrast */
        }

        input {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s; /* Transition for border color */
        }

        input:focus {
            border-color: #4CAF50; /* Change border color on focus */
            outline: none; /* Remove default outline */
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #4CAF50; /* Green background */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s; /* Transition for background and scale */
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
            transform: translateY(-2px); /* Lift effect on hover */
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #333; /* Message color */
        }

        .message.success {
            color: green; /* Success message color */
        }

        .message.error {
            color: red; /* Error message color */
        }

        a {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold; /* Make links bolder */
            transition: color 0.3s; /* Transition for link color */
        }

        a:hover {
            text-decoration: underline;
            color: #45a049; /* Darker green on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .registration-box {
                padding: 20px; /* Less padding on small screens */
            }

            h2 {
                font-size: 1.5em; /* Adjust heading size for mobile */
            }

            button {
                padding: 10px; /* Adjust button size for mobile */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="registration-box"> <!-- Added a div for the box -->
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
                <p class="message <?php echo strpos($message, 'Invalid') !== false ? 'error' : 'success'; ?>" style="text-align:center;">
                    <?php echo $message; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Add a class to the body when the page has loaded
        window.addEventListener('load', function () {
            document.body.classList.add('loaded');
        });
    </script>
</body>

</html>
