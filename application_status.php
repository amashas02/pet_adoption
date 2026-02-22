<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    echo "<p>You need to <a href='login.php'>login</a> to view your applications.</p>";
    exit();
}

// Get the user_id based on the username
$username = $_SESSION['username'];
$user_sql = "SELECT user_id FROM users WHERE username='$username'";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();
$user_id = $user['user_id'];

// Fetch adoption applications for the user
$sql = "SELECT a.application_id, p.name AS pet_name, a.status 
        FROM adoption_applications a 
        JOIN pets p ON a.pet_id = p.pet_id 
        WHERE a.user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arima', sans-serif;
            background-image: url('images/adoptstatus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: rgb(150, 153, 131);
        }

        nav {
            margin-bottom: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
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

        .application-status {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgb(150, 153, 131);
            color: white;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: rgb(150, 153, 131);
            margin-top: 20px;
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
        <li><a href="about.php" class="nav-button">About Us</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a class="nav-button" href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="register.php" class="nav-button">Register</a></li>
            <li><a href="login.php" class="nav-button">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="application-status">
    <h2>Your Adoption Applications</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Pet Name</th><th>Status</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['pet_name']) . "</td><td>" . htmlspecialchars($row['status']) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You have no adoption applications.</p>";
    }
    $conn->close();
    ?>
</div>

<footer>
    <p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
</footer>

</body>
</html>
