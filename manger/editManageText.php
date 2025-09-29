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
    <title>Edit Content - Church Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .page-container {
            max-width: 800px;
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
            min-height: 120px;
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

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 0 15px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="page-header">
            <h1><i class="fas fa-edit"></i> Edit Content</h1>
            <p>Update your content information</p>
        </div>

        <div class="form-card">
            <div class="form-header">
                <i class="fas fa-file-edit"></i>
                <h2>Content Details</h2>
            </div>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . urlencode($id); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="pageID">Select Page *</label>
                    <select name="pageID" id="pageID" required>
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
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="title">Content Title *</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($form_values['title']); ?>" required placeholder="Enter content title">
                </div>
                
                <div class="form-group">
                    <label for="link">External Link (Optional)</label>
                    <input type="text" id="link" name="link" value="<?php echo htmlspecialchars($form_values['link']); ?>" placeholder="https://example.com">
                </div>
                
                <div class="form-group">
                    <label for="linkText">Link Text (Optional)</label>
                    <input type="text" id="linkText" name="linkText" value="<?php echo htmlspecialchars($form_values['linkText']); ?>" placeholder="Click here to learn more">
                </div>
                
                <div class="form-group">
                    <label for="content">Content Description</label>
                    <textarea id="content" name="content" placeholder="Describe the content..."><?php echo htmlspecialchars($form_values['content']); ?></textarea>
                </div>
                
                <div class="action-buttons">
                    <button type="submit" name="edit_content" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Content
                    </button>
                    <a href="mangeText.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to List
                    </a>
                </div>
            </form>
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
    </script>
</body>
</html>
