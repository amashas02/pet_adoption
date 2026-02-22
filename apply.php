<?php
include 'db.php';
session_start();

if (isset($_SESSION['username'])) {
    $pet_id = $_GET['pet_id'];

    // Find the user_id based on the username
    $username = $_SESSION['username'];
    $user_sql = "SELECT user_id FROM users WHERE username='$username'";
    $user_result = $conn->query($user_sql);
    $user = $user_result->fetch_assoc();
    $user_id = $user['user_id'];

    // Insert the adoption application
    $sql = "INSERT INTO adoption_applications (user_id, pet_id, status) VALUES ('$user_id', '$pet_id', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Your adoption application has been submitted!";
        echo "<br><a href='application_status.php'>Check Application Status</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "You need to login to apply.";
}
?>
