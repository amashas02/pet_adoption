<?php
include 'db.php'; // Ensure this file exists to connect to the database
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into the database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Thank you, $name! Your message has been received.";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}

// Prefill the form with user data if logged in
$userName = "";
$userEmail = "";

// Check session is set and retrieve user details
if (isset($_SESSION['username'])) {
    $userName = $_SESSION['username'];
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Ensure email is set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arima', sans-serif; /* Ensures correct font usage */
            background-image: url('images/applicationback.jpg');
            background-size: cover; /* Covers the full page without distortion */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents repetition */
            background-attachment: fixed; /* Keeps the image fixed while scrolling */
            height: 100vh; /* Ensures it covers the full viewport height */
            margin: 0;
            padding: 0;
        }
        
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: rgb(150, 153, 131);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: rgb(150, 153, 131);
            margin-top: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        .nav-button {
            text-decoration: none;
            padding: 10px;
            background-color: #f04e30;
            color: white;
            border-radius: 5px;
        }

        .nav-button:hover {
            background-color: #c03e25;
        }

    main {
    text-align: left; /* Aligns text and form to the left */
    padding: 20px;
    margin-left: 100px; /* Moves content towards the left */
    max-width: 600px; /* Restricts width for better alignment */
}

form {
    max-width: 500px;
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
}


        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #f04e30;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c03e25;
        }
    </style>
</head>
<body>
<header>
    <h1>🐾 PawfectMatch</h1>
</header>

<nav>
    <ul>
        <li><a href="pets.php" class="nav-button">Home</a></li>
        <li><a href="application_status.php" class="nav-button">Application Status</a></li>
        <li><a href="contact_us.php" class="nav-button">Contact Us</a></li> 
        <li><a class="nav-button" href="about.php">About Us</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a class="nav-button" href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="register.php" class="nav-button">Register</a></li>
            <li><a href="login.php" class="nav-button">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

<main>
    <h2>Contact Us</h2>

    <?php
    if (isset($successMessage)) {
        echo "<p>$successMessage</p>";
    } elseif (isset($errorMessage)) {
        echo "<p>Error: $errorMessage</p>";
    }
    ?>

    <form action="contact_us.php" method="POST">
        <label for="name">Your Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $userName; ?>" required><br><br>

        <label for="email">Your Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $userEmail; ?>" required><br><br>

        <label for="message">Your Message:</label><br>
        <textarea id="message" name="message" rows="6" cols="50" required></textarea><br><br>

        <input type="submit" value="Send Message">
    </form>
</main>

<footer>
    <p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
</footer>
</body>
</html>
