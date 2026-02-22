<?php
include 'db.php'; // Include your database connection

// Define your admin credentials
$adminUsername = 'admin'; // Change to desired admin username
$adminPassword = 'admin123'; // Change to desired password

// Hash the password
$hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

// Prepare the SQL query to insert the admin account
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$role = 'admin'; // Set the role to 'admin'

if ($stmt) {
    $stmt->bind_param("sss", $adminUsername, $hashedPassword, $role);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Admin account created successfully.";
    } else {
        echo "Error creating admin account.";
    }

    $stmt->close();
} else {
    echo "Failed to prepare statement.";
}

$conn->close();
?>
