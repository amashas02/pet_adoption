<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p class='error-msg'>Username or email already taken.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'adopter')");
        $stmt->bind_param("sss", $username, $hashedPassword, $email);
        echo $stmt->execute() ? "<p class='success-msg'>Registration successful! <a href='login.php'>Login here</a>.</p>" 
                              : "<p class='error-msg'>Error: Please try again.</p>";
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/PawfectMatch.png') center/95% 105% no-repeat fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .container h1 {
            margin-bottom: 20px;
            font-size: 2em;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        input:focus {
            border-color: #007bff;
        }

        input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .error-msg, .success-msg {
            margin-top: 20px;
            padding: 10px;
            font-size: 1.1em;
            background: rgba(255, 255, 255, 1);
        }

        .error-msg { color: red; }
        .success-msg { color: green; }

        .login-link {
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            padding: 10px;
            background: rgb(150, 153, 131);
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Register</h1>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="submit" value="Register">
    </form>
    <div class="login-link">
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</div>

<footer>
    <p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
</footer>

</body>
</html>
