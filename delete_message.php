<?php
include 'db.php';

// Check if the message ID is passed and delete the message
if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];

    // Prepare the DELETE query
    $delete_sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $message_id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Redirect to admin dashboard after deletion
        header("Location: admin_dashboard.php?message=deleted");
    } else {
        // If there was an error, display a message
        echo "Error deleting message: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if no message ID is provided
    header("Location: admin_dashboard.php");
}
?>
