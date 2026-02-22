<?php
include 'db.php';
header('Content-Type: application/json');

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
echo json_encode($pets);
?>
