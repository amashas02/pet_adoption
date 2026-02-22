<?php
include 'db.php';

// Check if application_id is set
if (isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    // Prepare the SQL statement to update the application status to 'approved'
    $sql = "UPDATE adoption_applications SET status = 'approved' WHERE application_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $application_id);
    
    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "Application approved successfully!";
    } else {
        echo "Error approving application.";
    }

    $stmt->close();
    header("Location: admin_dashboard.php"); // Redirect back to the admin dashboard
}
?>
