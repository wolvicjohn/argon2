/* styles.css */
body {
    font-family: 'Roboto', sans-serif; /* Use a modern sans-serif font */
    margin: 0;
    padding: 50px;
    background-color: #18181b; /* Dark background */
    color: #ffffff; /* White text color */
}

h2 {
    color: #9146ff; /* Twitch purple */
    text-align: center;
    margin-bottom: 30px;
}

input {
    margin: 10px 0;
    padding: 15px;
    width: 300px;
    border: 1px solid #9146ff; /* Twitch purple border */
    border-radius: 5px;
    background-color: #23232a; /* Dark input background */
    color: #ffffff; /* White text color */
}

input:focus {
    outline: none;
    border-color: #ff477e; /* Pink border on focus */
}

button {
    padding: 10px 20px;
    cursor: pointer;
    background-color: #9146ff; /* Twitch purple */
    color: white;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #7e3af2; /* Darker purple on hover */
}

.password-strength {
    margin-top: 10px;
    height: 10px;
    width: 300px;
    background-color: #444; /* Darker background for strength meter */
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
    background-color: #4CAF50; /* Green for strong */
}

.message {
    margin-top: 5px;
    font-size: 14px;
    font-weight: bold;
    text-align: center; /* Centered text */
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #9146ff; /* Twitch purple */
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    color: #7e3af2; /* Darker purple on hover */
}
