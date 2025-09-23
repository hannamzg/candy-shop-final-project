<?php
session_start();
include '../connect.php';
$id = $conn->real_escape_string($_GET["id"]);

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

include('../manger/nav.php');

// Fetch class options
$sql_pages = "SELECT * FROM pages";
$result_pages = $conn->query($sql_pages);

// Function to edit content
function editContent($conn,  $pageID, $title, $link, $linkText, $content, $id) {
    // Properly escape variables to prevent SQL injection
    $sql = "UPDATE content SET  pageID = '$pageID', title = '$title', content = '$content', link = '$link', linkText = '$linkText' WHERE id = $id";
    echo $sql . ' ';
    if ($conn->query($sql) === TRUE) {
        // Successful update message can be added here or handled differently
    } else {
        echo "Error executing statement: " . htmlspecialchars($conn->error);
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_content"])) {
    $pageID = $conn->real_escape_string($_POST["pageID"]);
    $title = $conn->real_escape_string($_POST["title"]);
    $link = $conn->real_escape_string($_POST["link"]);
    $linkText = $conn->real_escape_string($_POST["linkText"]);
    $content = $conn->real_escape_string($_POST["content"]); // Escape content as well

    editContent($conn,  $pageID, $title, $link, $linkText, $content, $id);
    header("Location: mangeText.php");
    exit();
}

// Fetch existing content for editing
$sql_content = "SELECT * FROM content WHERE id = $id";
$form_values = $conn->query($sql_content)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Classes</title>
</head>

<body>
    <h1>Edit Your Content</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . urlencode($id); ?>" method="post" enctype="multipart/form-data">
        <label for="pageID">pageID:</label><br>
        <select name="pageID" id="pageID">
            <?php
            if ($result_pages->num_rows > 0) {
                while ($row = $result_pages->fetch_assoc()) {
                    $selected = ($form_values['pageID'] == $row["id"]) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row["id"]) . "' $selected>" . htmlspecialchars($row["pageName"]) . "</option>";
                }
            } else {
                echo "<option value=''>No pages available</option>";
            }
            ?>
        </select><br>
        
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($form_values['title']); ?>"><br>
        
        <label for="link">Link:</label><br>
        <input type="text" id="link" name="link" value="<?php echo htmlspecialchars($form_values['link']); ?>"><br>
        
        <label for="linkText">Link Text:</label><br>
        <input type="text" id="linkText" name="linkText" value="<?php echo htmlspecialchars($form_values['linkText']); ?>"><br>
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content"><?php echo htmlspecialchars($form_values['content']); ?></textarea><br><br>
        
        <input type="submit" name="edit_content" value="Edit" class="btn">
    </form>
</body>

<style>
    form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
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
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    .btn {
        background-color: #0056b3;
        color: white;
        padding: 10px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        width: 70px;
    }
</style>

</html>
