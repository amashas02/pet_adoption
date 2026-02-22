<?php
include 'db.php'; // Include the database connection

// Initialize variables for form data
$name = '';
$age = '';
$breed = '';
$species = '';
$description = '';
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and trim whitespace
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $breed = trim($_POST['breed']);
    $species = trim($_POST['species']);
    $description = trim($_POST['description']);

    // Ensure the target directory exists
    $target_dir = "images/pets imgs/"; // Directory where images will be uploaded
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }

    // Handle the file upload
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        $from = $_FILES['picture']['tmp_name'];
        $filename = basename($_FILES['picture']['name']);
        $to = $target_dir . $filename; // Combine target directory with filename

        // Check if the file is an actual image
        $check = getimagesize($from);
        if ($check === false) {
            $message = "File is not an image.";
        } else {
            // Check file size (limit to 2MB)
            if ($_FILES["picture"]["size"] > 2000000) {
                $message = "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                $imageFileType = strtolower(pathinfo($to, PATHINFO_EXTENSION));
                if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($from, $to)) {
                        // Prepare an SQL statement to insert the new pet
                        $sql = "INSERT INTO pets (name, age, breed, species, description, photo) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        
                        // Bind parameters to the SQL query
                        $stmt->bind_param("sissss", $name, $age, $breed, $species, $description, $to); // 's' for string, 'i' for integer
                        
                        // Execute the statement and check for success
                        if ($stmt->execute()) {
                            $message = "Pet added successfully!";
                            header("Location: admin_dashboard.php"); // Redirect to dashboard
                            exit();
                        } else {
                            $message = "Error: " . $stmt->error; // Capture error message
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        $message = "Failed to move uploaded file.";
                    }
                }
            }
        }
    } else {
        $message = "No file uploaded or upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Add Pet</title>
    <style>
        body {
            font-family: 'Arima', sans-serif; /* Corrected to use 'Arima' */
            background-image: url('images/addpet.jpg'); /* New background image */
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
            background-color: rgb(150, 153, 131); /* New header background color */
            text-align: center;
            padding: 20px;
            color: white;
        }

        footer {
            background-color: rgb(150, 153, 131); /* Footer background */
            padding: 10px;
            text-align: center;
            color: white;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Slight shadow for depth */
        }

        input[type="text"], input[type="number"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .nav-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
        }

        .nav-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Add a New Pet</h1>
</header>

<!-- Navigation button to go back to the admin dashboard -->
<a href="admin_dashboard.php" class="nav-button">Back to Admin Dashboard</a>

<!-- Display message if any -->
<?php if ($message) : ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<!-- Form to add a new pet -->
<div class="form-container"> <!-- Added a div to wrap the form -->
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="name">Pet Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required min="0">
        <br>
        
        <label for="breed">Breed:</label>
        <input type="text" id="breed" name="breed" required>
        
        <label for="species">Species:</label>
        <input type="text" id="species" name="species" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        
        <label for="picture">Upload Picture:</label>
        <input type="file" id="picture" name="picture" accept="image/*" required>

        <input type="submit" value="Add Pet">
    </form>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> 🐾 PawfectMatch. All rights reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
