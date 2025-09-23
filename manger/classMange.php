<?php
session_start();
include '../connect.php';
include '../GetClient.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

// Function to add content
function addContent($conn, $priority, $ClassID, $title, $link, $linkText, $content, $img, $clientID) {
    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO classpage (priority, ClassID, title, content, img, link, linkText, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return;
    }

    // Bind parameters to the statement
    // Note: Make sure to match the types correctly
    $stmt->bind_param("iisssssi", $priority, $ClassID, $title, $content, $img, $link, $linkText, $clientID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully.";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}






// Function to delete content
function deleteContent($conn, $id)
{
    // Query to fetch the filename based on the ID
    $img = '';
    $stmt = $conn->prepare("SELECT img FROM classpage WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($img);

    // Fetch the filename
    $stmt->fetch();
    $stmt->close();

    // Extracting the filename without the directory path
    $filename = basename($img);

    // Delete the file from the server
    $filePath = "../church/uploads/" . $filename;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Delete the record from the database
    $stmt = $conn->prepare("DELETE FROM classpage WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record and file deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_content"])) {
        // Process add content form
        $ClassID = $conn->real_escape_string($_POST["ClassID"]);
        $title = $conn->real_escape_string($_POST["title"]);
        $link =  $conn->real_escape_string($_POST["link"]);
        $linkText =  $conn->real_escape_string($_POST["linkText"]);
        $content =  $_POST["content"];
        $priority = $conn->real_escape_string($_POST["priority"]);
        $img = 'church/uploads/' . basename($conn->real_escape_string($_FILES["img"]["name"]));

        if (move_uploaded_file($_FILES["img"]["tmp_name"], '../' . $img)) {
            addContent($conn, $priority, $ClassID, $title, $link, $linkText, $content, basename($conn->real_escape_string($_FILES["img"]["name"])),$clientID);
        } else {
            addContent($conn, $priority, $ClassID, $title, $link, $linkText, $content, "",$clientID);
        }
    } elseif (isset($_POST["delete_content"])) {
        // Process delete content form
        $id = $_POST["id"];
        deleteContent($conn, $id);
    }
}

// Fetch pages for selection
$sql_pages = "SELECT * FROM class WHERE client_id = $clientID ";
$result_pages = $conn->query($sql_pages);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Class</title>
</head>

<body>
    <?php include('../manger/nav.php'); ?>

    <h1>Add New Content</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <label for="ClassID">ClassID:</label><br>

        <select name="ClassID" id="ClassID">
            <?php
            if ($result_pages->num_rows > 0) {
                while ($row = $result_pages->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["title"]) . "</option>";
                }
            } else {
                echo "<option value=''>No pages available</option>";
            }
            ?>
        </select><br>


        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="link">link:</label><br>
        <input type="text" id="link" name="link"><br>
        <label for="title">linkText:</label><br>
        <input type="text" id="linkText" name="linkText"><br>
        <label for="content">Content:</label><br>
        <textarea id="content" name="content"></textarea><br><br>
        <label for="img">Image:</label><br>
        <input type="file" id="img" name="img"><br><br>
        <label for="priority">Item Priority:</label><br>
        <input type="number" name="priority" id="priority" min="1"><br><br><br>
        <input type="submit" name="add_content" value="Add Content" class="btn">
    </form>

    <h1>Edit/Delete Content</h1>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php
        // Fetch classpage from database
        $sql_content = "SELECT * FROM classpage WHERE client_id = $clientID";
        $result_content = $conn->query($sql_content);

        if ($result_content->num_rows > 0) {
            while ($row = $result_content->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["content"]) . "</td>";
                echo "<td><img src='/church/uploads/" . htmlspecialchars($row["img"]) . "' style='max-width: 100px;'></td>";
                echo "<td>";
                echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                echo "<input type='hidden' name='title' value='" . htmlspecialchars($row["title"]) . "'>";
                echo "<input type='hidden' name='content' value='" . htmlspecialchars($row["content"]) . "'>";
                echo "<input type='hidden' name='img' value='" . htmlspecialchars($row["img"]) . "'>";
                echo "<a href='editClass.php?id=" . $row['id'] . "' name='edit_content' class='btn'>edit</a>";

                echo '<input type="submit" name="delete_content" value="Delete" style="background-color:red; color:white; cursor:pointer;">';
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No content available</td></tr>";
        }
        ?>
    </table>
</body>

</html>
<style>
    form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input[type="number"] {
        margin-bottom: 5px;
    }

    input[type="text"],
    textarea,
    select,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .btn {
        background-color: #0056b3;
        color: white;
        padding: 10px;
        border-radius: 10px;
        border: navajowhite;
        cursor: pointer;

    }
</style>