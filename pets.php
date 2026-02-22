<?php
include 'db.php';
session_start();

// Fetch one cat and one dog
$sqlCat = "SELECT * FROM pets WHERE species='Cat' AND status='available' LIMIT 1";
$catResult = $conn->query($sqlCat);
$cat = $catResult->fetch_assoc();

$sqlDog = "SELECT * FROM pets WHERE species='Dog' AND status='available' LIMIT 1";
$dogResult = $conn->query($sqlDog);
$dog = $dogResult->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Pets</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    background-image: url('images/homebackground.webp');
    background-size: 100% 100%; /* Ensures it covers the full width and height */
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed; /* Keeps the image fixed when scrolling */
    height: 100vh; /* Ensures it covers the full viewport height */
    width: 100vw; /* Ensures it covers the full viewport width */
    margin: 0;
    padding: 0;
}

        
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color:rgb(150, 153, 131);
        }
        header h1 {
            font-size: 2.5em;
            margin: 0;
            padding-right: 10px;
        }
        header h6 {
            font-size: 1.2em;
            margin: 0;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 10px;
        }
        nav a {
            text-decoration: none;
            color: #333;
            font-size: 1em;
            padding: 8px 12px;
            background-color: rgba(255, 111, 97, 0.9);
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }
        nav a:hover {
            background-color: rgba(255, 63, 49, 0.9);
        }
        .pets {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }
        .pet {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 15px;
            text-align: center;
            width: 250px;
        }
        .pet img {
            width: 100%;
            height: auto;
            border-radius: 20px;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            background-color:rgb(150, 153, 131);
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <div class="header">
        <h1>🐾 PawfectMatch</h1>
        <h6>Helping pets find their perfect home</h6>
    </div>
</header>

<nav>
    <ul>
        <li><a class="nav-button" href="pets.php">Home</a></li>
        <li><a class="nav-button" href="contact_us.php">Contact Us</a></li> <!-- Always visible -->
        <li><a class="nav-button" href="application_status.php">Application Status</a></li>
        <li><a class="nav-button" href="about.php">About Us</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a class="nav-button" href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a class="nav-button" href="register.php">Register</a></li>
            <li><a class="nav-button" href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

<main>
    <h2 style="background-color: rgba(255, 255, 255, 0.5); padding: 10px; border-radius: 5px;">Featured Pets for Adoption</h2>
    <div class="pets">
        <?php if ($cat): ?>
            <div class='pet'>
                <img src='<?php echo $cat['photo']; ?>' alt='<?php echo $cat['name']; ?>'>
                <h2><?php echo $cat['name']; ?></h2>
                <p>Species: <?php echo $cat['species']; ?></p>
                <p>Breed: <?php echo $cat['breed']; ?></p>
                <p>Age: <?php echo $cat['age']; ?></p>
                <p>Description: <?php echo $cat['description']; ?></p>
                <?php if (isset($_SESSION['username'])): ?>
                    <a class='nav-button' href='apply.php?pet_id=<?php echo $cat['pet_id']; ?>'>Apply for Adoption</a>
                <?php else: ?>
                    <a class='nav-button' href='login.php'>Login to Apply</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($dog): ?>
            <div class='pet'>
                <img src='<?php echo $dog['photo']; ?>' alt='<?php echo $dog['name']; ?>'>
                <h2><?php echo $dog['name']; ?></h2>
                <p>Species: <?php echo $dog['species']; ?></p>
                <p>Breed: <?php echo $dog['breed']; ?></p>
                <p>Age: <?php echo $dog['age']; ?></p>
                <p>Description: <?php echo $dog['description']; ?></p>
                <?php if (isset($_SESSION['username'])): ?>
                    <a class='nav-button' href='apply.php?pet_id=<?php echo $dog['pet_id']; ?>'>Apply for Adoption</a>
                <?php else: ?>
                    <a class='nav-button' href='login.php'>Login to Apply</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a class="nav-button" href="all_pets.php">View More Pets</a> <!-- Updated to link to all_pets.php -->
    </div>
</main>


<footer>
<p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
</footer>
</body>
</html>
