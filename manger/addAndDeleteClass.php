<?php
session_start();
include '../connect.php';
include '../GetClient.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

include('../manger/nav.php');

// Handle form submission to add a new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_class"])) {
    // Escape and trim input
    $title = $conn->real_escape_string(trim($_POST["title"]));

    // Prepare and execute the insert statement
    $stmt = $conn->prepare("INSERT INTO class (title, client_id) VALUES (?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("si", $title, $clientID);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // Success message (optional)
            echo "Class added successfully.";
        } else {
            echo "Failed to add class.";
        }
        
        $stmt->close();
    } else {
        // Handle statement preparation failure
        echo "Error preparing statement: " . $conn->error;
    }
}


// Handle deletion of a class
if (isset($_GET["delete_id"]) && is_numeric($_GET["delete_id"])) {
    $id = (int) $_GET["delete_id"]; // Ensure id is an integer
    $stmt = $conn->prepare("DELETE FROM class WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch existing classes using a prepared statement
$stmt = $conn->prepare("SELECT * FROM class WHERE client_id = $clientID ");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Manage Classes</h1>

    <!-- Form to add a new class -->
    <form method="POST" action="">
        <label for="title">Class Title:</label>
        <input type="text" id="title" name="title" required>
        <input type="submit" name="add_class" value="Add Class">
    </form>

    <h2>Existing Classes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["title"]) . "</td>
                        <td><a href='?delete_id=" . htmlspecialchars($row["id"]) . "' onclick='return confirm(\"Are you sure you want to delete this class?\");'>Delete</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No classes found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
