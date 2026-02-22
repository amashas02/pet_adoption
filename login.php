<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Query to select the user with their role
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session and set role
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Redirects admin to dashboard
            } else {
                header("Location: pets.php"); // Redirects adopter to pets page
            }
            exit(); // Ensure script stops after redirect
        } else {
            echo "<p class='error-msg'>Invalid credentials!</p>";
        }
    } else {
        echo "<p class='error-msg'>Invalid credentials!</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@300&display=swap" rel="stylesheet"> <!-- Include Arima font -->
    <style>
        body {
            font-family: 'Arima', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('images/login.jfif'); /* Set your background image here */
            background-size: cover;
            background-position: center;
        }

        header {
    position: absolute;
    top: 20px;
    left: 20px;
    color: black;
    background: none; /* Remove any background color */
}

        }

        h1 {
            font-size: 10.5em;
            margin: 0;
        }

        nav {
            margin-bottom: 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
            background-color: rgba(0, 0, 0, 0.5);
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .login-form {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .login-form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-form input[type="text"], .login-form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            background-color: rgba(255, 255, 255, 1);
        }

        .login-form input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-msg {
            color: red;
            background-color: rgba(255, 255, 255, 1);
            margin-top: 15px;
        }

        .signup-link {
            margin-top: 20px;
            font-size: 1em;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color:rgb(150, 153, 131);
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .login-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>🐾 PawfectMatch</h1>
    </header>

    <nav>
        <ul>
            <li><a class="nav-button" href="pets.php">Home</a></li>
            <li><a class="nav-button" href="register.php">Register</a></li>
            <li><a class="nav-button" href="login.php">Login</a></li>
            <li><a class="nav-button" href="application_status.php">Application Status</a></li>
            <li><a class="nav-button" href="contact_us.php">Contact Us</a></li>
        </ul>
    </nav>

    <div class="login-form">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
        
        <!-- New Sign Up Link -->
        <div class="signup-link">
            <p>New here? <a href="register.php">Sign up</a></p>
        </div>
    </div>

    <footer>
    <p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
    </footer>
</body>
</html>
