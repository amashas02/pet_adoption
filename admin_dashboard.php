<?php
include 'db.php';

// Handle message deletion
if (isset($_POST['delete_message_id'])) {
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $_POST['delete_message_id']);
    if ($stmt->execute()) {
        echo "<script>alert('Message deleted successfully.'); window.location.href='admin_dashboard.php';</script>";
    }
    $stmt->close();
}

// Retrieve data
$pet_result = $conn->query("SELECT pet_id, name, age, breed FROM pets");
$app_result = $conn->query("SELECT adoption_applications.application_id, users.username, pets.name AS pet_name, adoption_applications.status
                            FROM adoption_applications
                            JOIN users ON adoption_applications.user_id = users.user_id
                            JOIN pets ON adoption_applications.pet_id = pets.pet_id");
$contact_result = $conn->query("SELECT id, name AS user_name, email, message, sent_at FROM contact_messages ORDER BY sent_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arima:wght@400;700&display=swap');

        body {
            font-family: 'Arima', sans-serif;
            background: url('images/admindash.jpg') center/cover no-repeat fixed;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: rgb(150, 153, 131);
        }

        .logout-button {
        background-color: #dc3545; /* Red */
        padding: 10px 10px; /* Smaller padding */
        height: 30px;
        font-size: 20px; /* Reduced font size */
        border: 5px solid #b02a37; /* Small border for definition */
        border-radius: 10px; /* Slightly rounded corners */
        color: white;
        text-decoration: none;
        float: right;
}


        .logout-button:hover { background-color: #c82333; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th { background-color: rgba(0, 123, 255, 0.1); }
        tr:nth-child(even) { background-color: rgba(0, 0, 0, 0.05); }

        .transparent-box {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .add-button {
            background-color: #007bff;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            margin-left: 10px; /* Small spacing */
        }

        .add-button:hover { background-color: #0056b3; }

        .action-button {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            margin: 0 5px;
        }

        .edit-button { background-color: #28a745; }
        .delete-button { background-color: #dc3545; }

        .edit-button:hover { background-color: #218838; }
        .delete-button:hover { background-color: #c82333; }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <a href="logout.php" class="logout-button">Logout</a>
</header>

<div class="transparent-box">
<h2 style="display: inline-block;">Manage Pets</h2>
<a href="add_pet.php" class="add-button" style="margin-left: 15px;">Add Pet</a>

    <table>
        <tr>
            <th>Pet ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Breed</th>
        </tr>
        <?php while ($row = $pet_result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["pet_id"]) ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["age"]) ?></td>
            <td><?= htmlspecialchars($row["breed"]) ?></td>
        </tr>
        <?php endwhile; ?>
        
    </table>
</div>

<div class="transparent-box">
    <h2>Manage Applications</h2>
    <table>
        <tr>
            <th>Application ID</th>
            <th>User</th>
            <th>Pet Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $app_result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["application_id"]) ?></td>
            <td><?= htmlspecialchars($row["username"]) ?></td>
            <td><?= htmlspecialchars($row["pet_name"]) ?></td>
            <td><?= htmlspecialchars($row["status"]) ?></td>
            <td>
                <a href="approve_application.php?application_id=<?= $row['application_id'] ?>" class="action-button edit-button">Approve</a>
                <a href="reject_application.php?application_id=<?= $row['application_id'] ?>" class="action-button delete-button">Reject</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="transparent-box">
    <h2>Contact Us Messages</h2>
    <table>
        <tr>
            <th>Message ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $contact_result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["id"]) ?></td>
            <td><?= htmlspecialchars($row["user_name"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= nl2br(htmlspecialchars($row["message"])) ?></td>
            <td><?= htmlspecialchars($row["sent_at"]) ?></td>
            <td>
                <form method="POST" action="admin_dashboard.php" style="display:inline;">
                    <input type="hidden" name="delete_message_id" value="<?= $row['id'] ?>">
                    <input type="submit" value="Delete" class="action-button delete-button" onclick="return confirm('Are you sure you want to delete this message?');">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
