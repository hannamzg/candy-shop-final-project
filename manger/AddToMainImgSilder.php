<?php 
    session_start();
    include '../connect.php';
    include '../GetClient.php';

    if (!$_SESSION['adminUserName']) {
        header("Location: LogInToAdmin.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 10px;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>

<body>
    <?php include('../manger/nav.php'); ?>
    <div style="text-align: center;">
        <h1>Add to main slider img</h1>
    </div>

    <div>
        <?php
        // Handle delete request
        if (isset($_POST['delete_content'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $img = $conn->real_escape_string($_POST['img']);
            
            // Delete image record from database
            $sql_delete = "DELETE FROM mainsilderimg WHERE id = $id";
            if ($conn->query($sql_delete) === TRUE) {
                // Delete image file from server
                $file_path = '../church/uploads/' . $img;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                echo '<p class="success-message">Image deleted successfully!</p>';
            } else {
                echo '<p class="error-message">Error deleting image: ' . $conn->error . '</p>';
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require('../connect.php');

            $targetDir = '../church/uploads/';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
                
                print_r(mkdir($targetDir, 0755, true));
            }

            $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!empty($_FILES["photo"]["name"])) {
                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                if ($check === false) {
                    echo '<p class="error-message">Error: File is not an image.</p>';
                } else {
                    if ($_FILES["photo"]["size"] > 5000000) {
                        echo '<p class="error-message">Error: Sorry, your file is too large.</p>';
                    } else {
                        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
                        if (!in_array($imageFileType, $allowedExtensions)) {
                            echo '<p class="error-message">Error: Sorry, only JPG, JPEG, PNG, and GIF files are allowed.</p>';
                        } else {
                            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                                $date = date('Y-m-d_H-i-s'); 

                                $photoName = basename($_FILES["photo"]["name"]);
                                $pageID = $conn->real_escape_string($_POST['page']);

                                $sql = "INSERT INTO `mainsilderimg` (`img`,`page`,`client_id`) VALUES ('$photoName','$pageID','$clientID')";
                                if ($conn->query($sql) === TRUE) {
                                    echo '<p class="success-message">Image uploaded successfully!</p>';
                                } else {
                                    echo '<p class="error-message">Error: ' . $conn->error . '</p>';
                                }
                            } else {
                                echo '<p class="error-message">Error: Unable to move the uploaded file. Check directory permissions.</p>';
                            }
                        }
                    }
                }
            }
        }
        ?>

        <form action="/manger/AddToMainImgSilder.php" method="post" enctype="multipart/form-data">
            <label for="photo">Product Photo:</label>
            <input type="file" name="photo" accept="image/*" required>
            <br>
            <label for="page">Choose a page:</label>
            <select name="page" id="page">
              <option value="1">صور الصفحة الرئيسية</option>
              <?php
                 $sql_content = "SELECT * FROM `content` WHERE pageID = 8 AND client_id = $clientID";
                 $result_content = $conn->query($sql_content);
                 while ($row = $result_content->fetch_assoc()) {
                     echo '<option value="'.$row['id'].'"> '.$row['title'].' </option>';
                 }
                 
                 $sql_content = "SELECT * FROM `classpage` WHERE client_id = 2";  // Added WHERE clause
                 $result_content = $conn->query($sql_content);
                 while ($row = $result_content->fetch_assoc()) {
                     echo '<option value="'.$row['id'].'"> '.$row['title'].' </option>';
                 }
                 
              ?>
            </select>
            <input type="submit" value="Add Product">
        </form>
        <?php
            // Fetch content from database
            $sql_content = "SELECT * FROM mainsilderimg WHERE client_id = $clientID";
            $result_content = $conn->query($sql_content);

            if ($result_content->num_rows > 0) {
                while ($row = $result_content->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>"; 
                    echo "<td><img src='/church/uploads/" . htmlspecialchars($row["img"]) . "' style='max-width: 300px;'></td>"; // Display image   
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='img' value='" . htmlspecialchars($row["img"]) . "'>";
                    echo "<input type='submit' name='delete_content' value='Delete'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No content available</td></tr>";
            }
        ?>
    </div>

</body>
</html>
