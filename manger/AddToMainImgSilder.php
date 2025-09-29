<?php 
session_start();
include '../connect.php';
include '../GetClient.php';

if (!$_SESSION['adminUserName']) {
    header("Location: LogInToAdmin.php");
    exit();
}

$upload_success = false;
$upload_error = '';
$delete_success = false;
$delete_error = '';

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
        $delete_success = true;
    } else {
        $delete_error = 'Error deleting image: ' . $conn->error;
    }
}

// Handle upload request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_image'])) {
    $targetDir = '../church/uploads/';

    // Create directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (!empty($_FILES["photo"]["name"])) {
        // Generate unique filename
        $originalName = basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $uniqueName = time() . '_' . uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $uniqueName;

        // Check if file is an image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Check file size (5MB limit)
            if ($_FILES["photo"]["size"] <= 5000000) {
                // Check file extension
                $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");
                if (in_array($imageFileType, $allowedExtensions)) {
                    // Try to move uploaded file
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                        $pageID = $conn->real_escape_string($_POST['page']);

                        // Insert into database
                        $sql = "INSERT INTO `mainsilderimg` (`img`, `page`, `client_id`) VALUES ('$uniqueName', '$pageID', '$clientID')";
                        if ($conn->query($sql) === TRUE) {
                            $upload_success = true;
                        } else {
                            // If database insert fails, delete the uploaded file
                            unlink($targetFile);
                            $upload_error = 'Error inserting into database: ' . $conn->error;
                        }
                    } else {
                        $upload_error = 'Error: Unable to move the uploaded file.';
                    }
                } else {
                    $upload_error = 'Error: Only JPG, JPEG, PNG, GIF, and WebP files are allowed.';
                }
            } else {
                $upload_error = 'Error: File is too large. Maximum size is 5MB.';
            }
        } else {
            $upload_error = 'Error: File is not an image.';
        }
    } else {
        $upload_error = 'Error: No file selected.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Images Management - Church Management</title>
    <link rel="icon" href="../img/CrossIcon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .page-container {
            max-width: 1400px;
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
            grid-template-columns: 400px 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .upload-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 25px;
            border: 1px solid #e1e5e9;
            height: fit-content;
        }

        .upload-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f2f6;
        }

        .upload-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.3rem;
        }

        .upload-header i {
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

        .file-upload-area {
            border: 2px dashed #e1e5e9;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .file-upload-area:hover {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .file-upload-area.dragover {
            border-color: #667eea;
            background: #e8f0ff;
            transform: scale(1.02);
        }

        .file-upload-area input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 15px;
        }

        .upload-text {
            color: #666;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .upload-hint {
            color: #999;
            font-size: 0.8rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
            width: 100%;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .gallery-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e1e5e9;
        }

        .gallery-header {
            background: #f8f9fa;
            padding: 20px 25px;
            border-bottom: 1px solid #e1e5e9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .gallery-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .gallery-header i {
            color: #667eea;
        }

        .image-count {
            background: #667eea;
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 25px;
        }

        .image-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
        }

        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .image-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f8f9fa;
        }

        .image-info {
            padding: 15px;
        }

        .image-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.9rem;
            word-break: break-word;
        }

        .image-meta {
            color: #6c757d;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }

        .image-actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 0.85rem;
            flex: 1;
        }

        .btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-info {
            background: #17a2b8;
            color: #fff;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin: 0 0 10px;
            color: #495057;
            font-size: 1.2rem;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert i {
            font-size: 1.2rem;
        }

        .preview-container {
            margin-top: 15px;
            text-align: center;
        }

        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .images-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
                padding: 20px;
            }
            
            .gallery-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <?php include('../manger/nav.php'); ?>

    <div class="page-container">
        <div class="page-header">
            <h1><i class="fas fa-images"></i> Slider Images Management</h1>
            <p>Upload and manage images for your website slider</p>
        </div>

        <div class="content-grid">
            <div class="upload-card">
                <div class="upload-header">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <h2>Upload New Image</h2>
                </div>

                <?php if ($upload_success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        Image uploaded successfully!
                    </div>
                <?php endif; ?>

                <?php if ($upload_error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $upload_error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($delete_success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        Image deleted successfully!
                    </div>
                <?php endif; ?>

                <?php if ($delete_error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $delete_error; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Select Image *</label>
                        <input type="file" name="photo" accept="image/*" required class="form-control" style="padding: 10px; border: 2px dashed #e1e5e9; border-radius: 8px; background: #f8f9fa;">
                    </div>

                    <div class="form-group">
                        <label for="page">Assign to Page *</label>
                        <select name="page" required class="form-control">
                            <option value="">Choose a page...</option>
                            <option value="2">Gallery Page</option>
                            <?php
                            // Get additional content pages
                            $sql_content = "SELECT * FROM `content` WHERE client_id = $clientID GROUP BY pageID";
                            $result_content = $conn->query($sql_content);
                            if ($result_content && $result_content->num_rows > 0) {
                                while ($row = $result_content->fetch_assoc()) {
                                    echo '<option value="'.$row['pageID'].'">Content Page '.$row['pageID'].'</option>';
                                }
                            }
                            
                            // Get class pages
                            $sql_class = "SELECT * FROM `classpage` WHERE client_id = $clientID";
                            $result_class = $conn->query($sql_class);
                            if ($result_class && $result_class->num_rows > 0) {
                                while ($row = $result_class->fetch_assoc()) {
                                    echo '<option value="class_'.$row['id'].'">Class: '.htmlspecialchars($row['title']).'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="upload_image" class="btn btn-primary">
                        <i class="fas fa-upload"></i>
                        Upload Image
                    </button>
                </form>
                
            </div>

            <div class="gallery-container">
                <div class="gallery-header">
                    <h2><i class="fas fa-images"></i> Current Images</h2>
                    <div class="image-count" id="imageCount">0 images</div>
                </div>
                
                <div class="images-grid" id="imagesGrid">
                    <?php
                    $sql_content = "SELECT * FROM mainsilderimg WHERE client_id = $clientID ORDER BY id DESC";
                    $result_content = $conn->query($sql_content);
                    $image_count = 0;

                    if ($result_content->num_rows > 0) {
                        while ($row = $result_content->fetch_assoc()) {
                            $image_count++;
                            echo '<div class="image-card">';
                            echo '<img src="../church/uploads/' . htmlspecialchars($row["img"]) . '" class="image-preview" alt="Slider image" loading="lazy">';
                            echo '<div class="image-info">';
                            echo '<div class="image-name">' . htmlspecialchars($row["img"]) . '</div>';
                            echo '<div class="image-meta">Page ID: ' . htmlspecialchars($row["page"]) . '</div>';
                            echo '<div class="image-actions">';
                            echo '<a href="../church/uploads/' . htmlspecialchars($row["img"]) . '" target="_blank" class="btn btn-info btn-sm">';
                            echo '<i class="fas fa-eye"></i> View';
                            echo '</a>';
                            echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post" style="display: inline; flex: 1;">';
                            echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                            echo '<input type="hidden" name="img" value="' . htmlspecialchars($row["img"]) . '">';
                            echo '<button type="submit" name="delete_content" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this image?\')">';
                            echo '<i class="fas fa-trash"></i> Delete';
                            echo '</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="empty-state">';
                        echo '<i class="fas fa-image"></i>';
                        echo '<h3>No Images Found</h3>';
                        echo '<p>Upload your first slider image using the form on the left.</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update image count
        document.getElementById('imageCount').textContent = '<?php echo $image_count; ?> images';

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>
