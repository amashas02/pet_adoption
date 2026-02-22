<?php
include 'db.php'; // connect to the database
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        body {
            font-family: 'Arima', sans-serif;
            background-image: url('images/contactbackground.jpg');
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
            margin-bottom: 30px; /* Added space below navbar */
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

        main {
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            max-width: 800px;
            margin: 50px auto; /* Added more margin to move it lower */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: rgb(150, 153, 131);
        }

        h2 {
            font-weight: bold; /* Kept bold but removed underline */
            text-decoration: none;
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
            <li><a class="nav-button" href="contact_us.php">Contact Us</a></li>
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
        <h2>About Us</h2>
        
        <section>
            <h2>Who We Are</h2>
            <p>At PawfectMatch, we are more than just a pet adoption platform—we are a compassionate community dedicated to transforming the lives of both pets and people. Our goal is to make adoption a seamless, rewarding, and heartwarming experience, ensuring that every pet finds the perfect home and every adopter feels supported.</p>

            <p>We work closely with shelters, rescues, and pet lovers to simplify the adoption process, provide educational resources, and advocate for responsible pet ownership. Whether you’re looking for a furry friend or seeking guidance on pet care, we’re here to help every step of the way.</p>

            <p>Because at PawfectMatch, we believe that every pet deserves love, every adopter deserves guidance, and every adoption is a chance for a beautiful new beginning. 🐾💙</p>
        </section>

        <section>
            <h2>Our Mission</h2>
            <p>Our mission is to connect loving families with homeless pets, ensuring that every animal finds a safe, caring, and forever home. We are committed to reducing animal homelessness, promoting responsible pet ownership, and fostering a compassionate community where pets and people thrive together.</p>

            <p>Through education, advocacy, and support, we strive to make a difference—one adoption at a time. Because every pet deserves a second chance, and every family deserves the unconditional love of a furry companion. 🐶🐱💕</p>
        </section>  
    </main>

    <footer>
        <p>Contact us: PawfectMatch@gmail.com</p>
        <p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
    </footer>
</body>
</html>
