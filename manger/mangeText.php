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
function addContent($conn, $page_id, $title, $link, $linkText, $content, $img, $clientID) {
    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO content (pageID, title, content, img, link, linkText, client_id) VALUES (?, ?, ?, ?, ?, ? ,?)");
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return;
    }

    // Bind parameters to the statement
    $stmt->bind_param("isssssi", $page_id, $title, $content, $img, $link, $linkText, $clientID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}




// Function to edit content
function editContent($conn, $id, $title, $content, $img) {
    $stmt = $conn->prepare("UPDATE content SET title=?, content=?, img=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $content, $img, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

// Function to delete content
function deleteContent($conn, $id) {
    // Query to fetch the filename based on the ID
    $img = '';
    $stmt = $conn->prepare("SELECT img FROM content WHERE id=?");
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
    $stmt = $conn->prepare("DELETE FROM content WHERE id=?");
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
        $page_id = $conn->real_escape_string($_POST["page_id"]);
        $title =  $conn->real_escape_string($_POST["title"]);
        $link =  $conn->real_escape_string($_POST["link"]);
        $linkText =  $conn->real_escape_string($_POST["linkText"]);
        $content =  $_POST["content"];
        $img =  basename( $conn->real_escape_string($_FILES["img"]["name"]));

        if (move_uploaded_file($_FILES["img"]["tmp_name"], '../church/uploads/' . $img)) {
            addContent($conn, $page_id, $title, $link, $linkText, $content, $img, $clientID);
        } else {
            addContent($conn, $page_id, $title, $link, $linkText, $content, "", $clientID);
        }
    } elseif (isset($_POST["edit_content"])) {
        // Process edit content form
        $id = $_POST["id"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $img = basename($_FILES["img"]["name"]);

        if (move_uploaded_file($_FILES["img"]["tmp_name"], '../' . $img)) {
            editContent($conn, $id, $title, $content, $img);
        } else {
            editContent($conn, $id, $title, $content, "");
        }
    } elseif (isset($_POST["delete_content"])) {
        // Process delete content form
        $id = $_POST["id"];
        deleteContent($conn, $id);
    }
}

// Fetch pages for selection
$sql_pages = "SELECT * FROM pages";
$result_pages = $conn->query($sql_pages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Manage Content - Church Management</title>
    <link rel="icon" href="../img/CrossIcon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .page-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 25px;
            border: 1px solid #e1e5e9;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f2f6;
        }

        .form-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.3rem;
        }

        .form-header i {
            color: #667eea;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .table-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e1e5e9;
        }

        .table-header {
            background: #f8f9fa;
            padding: 20px 25px;
            border-bottom: 1px solid #e1e5e9;
        }

        .table-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-header i {
            color: #667eea;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #667eea;
            color: #fff;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #e1e5e9;
            vertical-align: top;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .content-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e1e5e9;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 0.85rem;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin: 0 0 10px;
            color: #495057;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .data-table {
                font-size: 0.85rem;
            }
            
            .data-table th,
            .data-table td {
                padding: 10px 8px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include('../manger/nav.php'); ?>
    
    <div class="page-container">
        <div class="page-header">
            <h1><i class="fas fa-file-alt"></i> Manage Content</h1>
            <p>Add and manage your church content across different pages</p>
        </div>

        <div class="content-grid">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-plus-circle"></i>
                    <h2>Add New Content</h2>
                </div>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="page_id">Select Page *</label>
                        <select name="page_id" id="page_id" required>
                            <option value="">Choose a page...</option>
                            <?php
                            if ($result_pages->num_rows > 0) {
                                while ($row = $result_pages->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["pageName"]) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No pages available</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Content Title *</label>
                        <input type="text" id="title" name="title" required placeholder="Enter content title">
                    </div>

                    <div class="form-group">
                        <label for="content">Content Description</label>
                        <textarea id="content" name="content" placeholder="Describe the content..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="link">External Link (Optional)</label>
                        <input type="text" id="link" name="link" placeholder="https://example.com">
                    </div>

                    <div class="form-group">
                        <label for="linkText">Link Text (Optional)</label>
                        <input type="text" id="linkText" name="linkText" placeholder="Click here to learn more">
                    </div>

                    <div class="form-group">
                        <label for="img">Content Image</label>
                        <input type="file" id="img" name="img" accept="image/*">
                    </div>

                    <button type="submit" name="add_content" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Add Content
                    </button>
                </form>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h2><i class="fas fa-list"></i> Existing Content</h2>
                </div>
                
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch content from database
                            $sql_content = "SELECT * FROM content WHERE client_id = $clientID";
                            $result_content = $conn->query($sql_content);

                            if ($result_content->num_rows > 0) {
                                while ($row = $result_content->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><span style='background: #667eea; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;'>" . htmlspecialchars($row["id"]) . "</span></td>";
                                    echo "<td><strong>" . htmlspecialchars($row["title"]) . "</strong></td>";
                                    echo "<td><div class='content-preview'>" . htmlspecialchars($row["content"]) . "</div></td>";
                                    echo "<td>";
                                    if ($row["img"]) {
                                        echo "<img src='/church/uploads/" . htmlspecialchars($row["img"]) . "' class='image-preview' alt='Content image'>";
                                    } else {
                                        echo "<div style='width: 60px; height: 60px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;'><i class='fas fa-image'></i></div>";
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<div class='action-buttons'>";
                                    echo "<a href='editManageText.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>";
                                    echo "<i class='fas fa-edit'></i> Edit";
                                    echo "</a>";
                                    
                                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' style='display: inline;'>";
                                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                                    echo "<input type='hidden' name='title' value='" . htmlspecialchars($row["title"]) . "'>";
                                    echo "<input type='hidden' name='content' value='" . htmlspecialchars($row["content"]) . "'>";
                                    echo "<input type='hidden' name='img' value='" . htmlspecialchars($row["img"]) . "'>";
                                    echo "<button type='submit' name='delete_content' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this content?\")'>";
                                    echo "<i class='fas fa-trash'></i> Delete";
                                    echo "</button>";
                                    echo "</form>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>";
                                echo "<div class='empty-state'>";
                                echo "<i class='fas fa-inbox'></i>";
                                echo "<h3>No Content Found</h3>";
                                echo "<p>Start by adding some content using the form on the left.</p>";
                                echo "</div>";
                                echo "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e1e5e9';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        // File input preview
        document.getElementById('img').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You could add image preview here if needed
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>


