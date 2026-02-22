<?php
include 'db.php';
session_start();

// Fetch all available pets
$sql = "SELECT * FROM pets WHERE status='available'";
$result = $conn->query($sql);
$pets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Available Pets</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@300&display=swap" rel="stylesheet"> <!-- Link to Google Fonts -->
    <script src="pets.js" defer></script>
    <style>
        body {
            font-family: 'Arima', sans-serif; /* Corrected to use 'Arima' */
            background-image: url('images/allpetbackground.webp');
            background-size: cover;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Keeps the image fixed when scrolling */
            height: 100vh; /* Ensures it covers the full viewport height */
            width: 100vw; /* Ensures it covers the full viewport width */
            margin: 0;
            padding: 0;
        }
        header {
            text-align: left;
            padding: 5px;
            background-color:rgb(150, 153, 131);
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color:rgb(150, 153, 131);
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
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
            flex-direction: column;
            align-items: center;
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
            border-radius: 8px;
        }
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            width: 250px;
        }
        button {
            border: none;
            border-radius: 15px;
            background-color: rgba(255, 111, 97, 0.9);
            color: Black;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        button:hover {
            background-color: rgba(255, 63, 49, 0.9);
        }
    </style>
</head>
<body>
<header>
    <h1>🐾 PawfectMatch</h1>
    <h3>Helping pets find their perfect home</h3>
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
<h2 style="background-color: rgba(255, 255, 255, 0.5); padding: 10px; border-radius: 5px;">All Available Pets</h2>
    <div class="pets" id="pets-container">
        <!-- Single pet card will be injected here by JavaScript -->
    </div>

    <div class="nav-buttons">
        <button id="prev-btn" style="display: none;">Previous</button>
        <button id="next-btn">Next</button>
    </div>
</main>

<footer>
<p>&copy; 2025 🐾 PawfectMatch | All rights reserved.</p>
</footer>

<script>
    const pets = <?php echo json_encode($pets); ?>; // Pass PHP array to JavaScript
    let currentPetIndex = 0;

    function showPet(index) {
        const petContainer = document.getElementById('pets-container');
        const pet = pets[index];
        petContainer.innerHTML = `
            <div class='pet'>
                <img src='${pet.photo}' alt='${pet.name}'>
                <h2>${pet.name}</h2>
                <p>Species: ${pet.species}</p>
                <p>Breed: ${pet.breed}</p>
                <p>Age: ${pet.age}</p>
                <p>Description: ${pet.description}</p>
                <?php if (isset($_SESSION['username'])): ?>
                    <a class='nav-button' href='apply.php?pet_id=${pet.pet_id}'>Apply for Adoption</a>
                <?php else: ?>
                    <a class='nav-button' href='login.php'>Login to Apply</a>
                <?php endif; ?>
            </div>
        `;
        document.getElementById('prev-btn').style.display = index === 0 ? 'none' : 'block';
        document.getElementById('next-btn').style.display = index === pets.length - 1 ? 'none' : 'block';
    }

    document.getElementById('next-btn').addEventListener('click', () => {
        if (currentPetIndex < pets.length - 1) {
            currentPetIndex++;
            showPet(currentPetIndex);
        }
    });

    document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentPetIndex > 0) {
            currentPetIndex--;
            showPet(currentPetIndex);
        }
    });

    showPet(currentPetIndex);
</script>
</body>
</html>
