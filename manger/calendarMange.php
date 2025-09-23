<?php
session_start();
include '../connect.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

// Function to add a program item
if (isset($_POST['add'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $location = $conn->real_escape_string($_POST['location']);

    $stmt = $conn->prepare("INSERT INTO weekly_program (title, description, date, time, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $date, $time, $location);

    if ($stmt->execute()) {
        header("Location: calendarMange.php");
        exit();
    } else {
        echo "Error adding program item.";
    }
}

// Function to update a program item
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE weekly_program SET title=?, description=?, date=?, time=?, location=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $date, $time, $location, $id);

    if ($stmt->execute()) {
        header("Location: calendarMange.php");
        exit();
    } else {
        echo "Error updating program item.";
    }
}

// Function to delete a program item
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM weekly_program WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: calendarMange.php");
        exit();
    } else {
        echo "Error deleting program item.";
    }
}

// Fetch program data
$result = $conn->query("SELECT * FROM weekly_program ORDER BY date, time");

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Program Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="time"],
        form input[type="submit"] {
            width: calc(100% - 20px);
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td a {
            display: inline-block;
            margin-right: 10px;
            color: #333;
            text-decoration: none;
        }

        td a:hover {
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <?php include('../manger/nav.php'); ?>
    <h1>Weekly Program Management</h1>
    <form method="post" action="">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="description" placeholder="Description">
        <input type="date" name="date" required>
        <input type="time" name="time">
        <input type="text" name="location" placeholder="Location">
        <input type="submit" name="add" value="Add Program">
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['title']; ?></td>
                        <td><?= $row['description']; ?></td>
                        <td><?= $row['date']; ?></td>
                        <td><?= $row['time']; ?></td>
                        <td><?= $row['location']; ?></td>
                        <td>
                            <a href="calendarMange.php?delete=<?= $row['id']; ?>" onclick="return ('Are you sure you want to delete this item?')">Delete</a>
                            <!--<a href="editProgram.php?id=<?= $row['id']; ?>">Edit</a>-->
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">No program data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>