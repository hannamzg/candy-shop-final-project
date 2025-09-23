<?php
session_start();
include '../connect.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

// Include GetClient.php to retrieve ClientID
include '../GetClient.php';

// Initialize variables for form values
$client_name = $facebook = $icon = $background_img1 = $background_img2 = $background_img3 = $description = $title_page2 = $title_page3 = "";

// Fetch existing data if ClientID is provided
$sql = "SELECT * FROM general_elements WHERE ClientID = $clientID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $client_name = $row['client_name'];
    $facebook = $row['facebook'];
    $icon = $row['icon'];
    $background_img1 = $row['background_img1'];
    $background_img2 = $row['background_img2'];
    $background_img3 = $row['background_img3'];
    $description = $row['description'];
    $title_page2 = $row['title_page2']; // Fetch title_page2
    $title_page3 = $row['title_page3']; // Fetch title_page3
}

// Function to handle file uploads
function uploadFile($fileInputName, $existingFile, $timestamp) {
    if ($_FILES[$fileInputName]['size'] > 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Allowed file types
        $fileType = $_FILES[$fileInputName]['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            $filename = $timestamp . "_" . basename($_FILES[$fileInputName]['name']);
            move_uploaded_file($_FILES[$fileInputName]["tmp_name"], '../church/uploads/' . $filename);
            return $filename;
        } else {
            echo "Invalid file type for $fileInputName.";
            return $existingFile; // Return old file if invalid
        }
    }
    return $existingFile; // No file uploaded, return old file
}

// Process form submission for insert or update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values and escape them
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $facebook = $conn->real_escape_string($_POST['facebook']);
    $description = $conn->real_escape_string($_POST['description']);
    $title_page2 = $conn->real_escape_string($_POST['title_page2']); // New field
    $title_page3 = $conn->real_escape_string($_POST['title_page3']); // New field
    
    // Get the current timestamp for unique filenames
    $timestamp = date("YmdHis");

    // Handle file uploads
    $icon_new = uploadFile('icon', $icon, $timestamp);
    $background_img1_new = uploadFile('background_img1', $background_img1, $timestamp);
    $background_img2_new = uploadFile('background_img2', $background_img2, $timestamp);
    $background_img3_new = uploadFile('background_img3', $background_img3, $timestamp);

    // Check if record exists to determine insert or update
    if ($result->num_rows > 0) {
        // Update the database
        $sql = "UPDATE general_elements SET client_name = '$client_name', facebook = '$facebook', 
                icon = '$icon_new', background_img1 = '$background_img1_new', 
                background_img2 = '$background_img2_new', background_img3 = '$background_img3_new', 
                description = '$description', title_page2 = '$title_page2', title_page3 = '$title_page3' 
                WHERE ClientID = $clientID";
        $action = "updated";
    } else {
        // Insert a new record
        $sql = "INSERT INTO general_elements (ClientID, client_name, facebook, icon, 
                background_img1, background_img2, background_img3, description, title_page2, title_page3) 
                VALUES ($clientID, '$client_name', '$facebook', '$icon_new', 
                '$background_img1_new', '$background_img2_new', '$background_img3_new', '$description', 
                '$title_page2', '$title_page3')";
        $action = "inserted";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record successfully $action!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit General Elements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #4cae4c;
        }
    </style>
</head>
<body>
<?php include('../manger/nav.php'); ?>

    <h1><?php echo $result->num_rows > 0 ? 'Edit' : 'Add'; ?> General Elements</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="client_name">Client Name:</label>
        <input type="text" name="client_name" value="<?php echo htmlspecialchars($client_name); ?>" required>

        <label for="facebook">Facebook:</label>
        <input type="text" name="facebook" value="<?php echo htmlspecialchars($facebook); ?>">

        <label for="icon">Icon:</label>
        <input type="file" name="icon">
        <p>Current: <?php echo htmlspecialchars($icon); ?></p>

        <label for="background_img1">Background Image 1:</label>
        <input type="file" name="background_img1">
        <p>Current: <?php echo htmlspecialchars($background_img1); ?></p>

        <label for="background_img2">Background Image 2:</label>
        <input type="file" name="background_img2">
        <p>Current: <?php echo htmlspecialchars($background_img2); ?></p>

        <label for="background_img3">Background Image 3:</label>
        <input type="file" name="background_img3">
        <p>Current: <?php echo htmlspecialchars($background_img3); ?></p>

        <label for="description">Description:</label>
        <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>

        <label for="title_page2">Title Page 2:</label>
        <input type="text" name="title_page2" value="<?php echo htmlspecialchars($title_page2); ?>">

        <label for="title_page3">Title Page 3:</label>
        <input type="text" name="title_page3" value="<?php echo htmlspecialchars($title_page3); ?>">

        <input type="submit" value="<?php echo $result->num_rows > 0 ? 'Update' : 'Add'; ?>">
    </form>
</body>
</html>
