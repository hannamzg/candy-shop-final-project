<?php
session_start();
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

include '../connect.php';
include '../GetClient.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_product':
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = floatval($_POST['price']);
                $category = mysqli_real_escape_string($conn, $_POST['category']);
                $stock_quantity = intval($_POST['stock_quantity']);
                $featured = isset($_POST['featured']) ? 1 : 0;
                $weight = mysqli_real_escape_string($conn, $_POST['weight']);
                $material = mysqli_real_escape_string($conn, $_POST['material']);
                $color = mysqli_real_escape_string($conn, $_POST['color']);
                $tags = mysqli_real_escape_string($conn, $_POST['tags']);
                
                // Handle file upload
                $photo = '';
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                    $uploadDir = '../church/uploads/';
                    $fileName = time() . '_' . basename($_FILES['photo']['name']);
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                        $photo = $fileName;
                    }
                }
                
                $sql = "INSERT INTO products (client_id, name, description, price, photo, category, stock_quantity, featured, weight, material, color, tags) 
                        VALUES ($clientID, '$name', '$description', $price, '$photo', '$category', $stock_quantity, $featured, '$weight', '$material', '$color', '$tags')";
                
                if ($conn->query($sql)) {
                    $message = 'Product added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding product: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
                
            case 'edit_product':
                $id = intval($_POST['product_id']);
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = floatval($_POST['price']);
                $category = mysqli_real_escape_string($conn, $_POST['category']);
                $stock_quantity = intval($_POST['stock_quantity']);
                $featured = isset($_POST['featured']) ? 1 : 0;
                $weight = mysqli_real_escape_string($conn, $_POST['weight']);
                $material = mysqli_real_escape_string($conn, $_POST['material']);
                $color = mysqli_real_escape_string($conn, $_POST['color']);
                $tags = mysqli_real_escape_string($conn, $_POST['tags']);
                
                // Handle file upload
                $photo = '';
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                    $uploadDir = '../church/uploads/';
                    $fileName = time() . '_' . basename($_FILES['photo']['name']);
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                        $photo = $fileName;
                        $photoUpdate = ", photo = '$photo'";
                    } else {
                        $photoUpdate = "";
                    }
                } else {
                    $photoUpdate = "";
                }
                
                $sql = "UPDATE products SET 
                        name = '$name', 
                        description = '$description', 
                        price = $price, 
                        category = '$category', 
                        stock_quantity = $stock_quantity, 
                        featured = $featured, 
                        weight = '$weight', 
                        material = '$material', 
                        color = '$color', 
                        tags = '$tags'
                        $photoUpdate
                        WHERE id = $id AND client_id = $clientID";
                
                if ($conn->query($sql)) {
                    $message = 'Product updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating product: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
                
            case 'delete_product':
                $id = intval($_POST['product_id']);
                $sql = "DELETE FROM products WHERE id = $id AND client_id = $clientID";
                
                if ($conn->query($sql)) {
                    $message = 'Product deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting product: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
                
            case 'toggle_status':
                $id = intval($_POST['product_id']);
                $sql = "UPDATE products SET is_active = NOT is_active WHERE id = $id AND client_id = $clientID";
                
                if ($conn->query($sql)) {
                    $message = 'Product status updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating product status: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
                
            case 'add_category':
                $name = mysqli_real_escape_string($conn, $_POST['category_name']);
                $description = mysqli_real_escape_string($conn, $_POST['category_description']);
                $icon = mysqli_real_escape_string($conn, $_POST['category_icon']);
                $sort_order = intval($_POST['category_sort_order']);
                
                $sql = "INSERT INTO product_categories (client_id, name, description, icon, sort_order) 
                        VALUES ($clientID, '$name', '$description', '$icon', $sort_order)";
                
                if ($conn->query($sql)) {
                    $message = 'Category added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding category: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
                
            case 'edit_category':
                $id = intval($_POST['category_id']);
                $name = mysqli_real_escape_string($conn, $_POST['category_name']);
                $description = mysqli_real_escape_string($conn, $_POST['category_description']);
                $icon = mysqli_real_escape_string($conn, $_POST['category_icon']);
                $sort_order = intval($_POST['category_sort_order']);
                
                $sql = "UPDATE product_categories SET 
                        name = '$name', 
                        description = '$description', 
                        icon = '$icon', 
                        sort_order = $sort_order
                        WHERE id = $id AND client_id = $clientID";
                
                if ($conn->query($sql)) {
                    $message = 'Category updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating category: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
                
            case 'delete_category':
                $id = intval($_POST['category_id']);
                
                // Check if category has products
                $check_sql = "SELECT COUNT(*) as count FROM products WHERE category = (SELECT name FROM product_categories WHERE id = $id AND client_id = $clientID) AND client_id = $clientID";
                $check_result = $conn->query($check_sql);
                $product_count = $check_result->fetch_assoc()['count'];
                
                if ($product_count > 0) {
                    $message = 'Cannot delete category. It has ' . $product_count . ' product(s) assigned to it.';
                    $messageType = 'error';
                } else {
                    $sql = "DELETE FROM product_categories WHERE id = $id AND client_id = $clientID";
                    
                    if ($conn->query($sql)) {
                        $message = 'Category deleted successfully!';
                        $messageType = 'success';
                    } else {
                        $message = 'Error deleting category: ' . $conn->error;
                        $messageType = 'error';
                    }
                }
                break;
                
            case 'toggle_category_status':
                $id = intval($_POST['category_id']);
                $sql = "UPDATE product_categories SET is_active = NOT is_active WHERE id = $id AND client_id = $clientID";
                
                if ($conn->query($sql)) {
                    $message = 'Category status updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating category status: ' . $conn->error;
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get all products
$products = $conn->query("SELECT * FROM products WHERE client_id = $clientID ORDER BY created_at DESC");

// Get categories
$categories = $conn->query("SELECT * FROM product_categories WHERE client_id = $clientID AND is_active = 1 ORDER BY sort_order, name");

// Get all categories for management
$all_categories = $conn->query("SELECT * FROM product_categories WHERE client_id = $clientID ORDER BY sort_order, name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Product Management - Church Admin</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .tabs {
            display: flex;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 5px;
            margin-bottom: 30px;
        }

        .tab {
            flex: 1;
            padding: 15px 20px;
            text-align: center;
            background: transparent;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .tab.active {
            background: #667eea;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
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
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .product-category {
            background: #f8f9fa;
            color: #6c757d;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 10px;
        }

        .product-stock {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: inline-block;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .featured-badge {
            background: #ffc107;
            color: #212529;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: inline-block;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e1e5e9;
        }

        .modal-header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .close {
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }

        .close:hover {
            color: #000;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 25px;
            font-size: 1rem;
            background: white;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #667eea;
        }

        .categories-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e5e9;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e1e5e9;
        }

        .section-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.5rem;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .category-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .category-info {
            flex: 1;
        }

        .category-info h3 {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .category-info p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .category-status {
            flex-shrink: 0;
        }

        .category-details {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .detail-item i {
            color: #667eea;
        }

        .category-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .icon-preview {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #f8f9fa;
            border: 1px solid #e1e5e9;
            border-radius: 6px;
            text-align: center;
            line-height: 28px;
            margin-left: 10px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .tabs {
                flex-direction: column;
            }
            
            .product-actions {
                flex-direction: column;
            }
            
            .category-actions {
                flex-direction: column;
            }
            
            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <?php include('../manger/nav.php'); ?>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-shopping-bag"></i> Product Management</h1>
            <p>Manage your church products, inventory, and pricing</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="tabs">
            <button class="tab active" onclick="showTab('products')">
                <i class="fas fa-list"></i> View Products
            </button>
            <button class="tab" onclick="showTab('add')">
                <i class="fas fa-plus"></i> Add Product
            </button>
            <button class="tab" onclick="showTab('categories')">
                <i class="fas fa-tags"></i> Manage Categories
            </button>
        </div>

        <!-- View Products Tab -->
        <div id="products" class="tab-content active">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search products by name, category, or tags..." onkeyup="filterProducts()">
            </div>
            
            <div class="products-grid" id="productsGrid">
                <?php while ($product = $products->fetch_assoc()): ?>
                    <div class="product-card" data-name="<?php echo strtolower($product['name']); ?>" 
                         data-category="<?php echo strtolower($product['category']); ?>" 
                         data-tags="<?php echo strtolower($product['tags']); ?>">
                        
                        <?php if ($product['featured']): ?>
                            <div class="featured-badge">
                                <i class="fas fa-star"></i> Featured
                            </div>
                        <?php endif; ?>
                        
                        <div class="status-badge <?php echo $product['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo $product['is_active'] ? 'Active' : 'Inactive'; ?>
                        </div>
                        
                        <?php if ($product['photo']): ?>
                            <img src="../church/uploads/<?php echo htmlspecialchars($product['photo']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-image">
                        <?php else: ?>
                            <div class="product-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                <i class="fas fa-image" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                        <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                        <div class="product-category"><?php echo htmlspecialchars($product['category']); ?></div>
                        <div class="product-stock">
                            <i class="fas fa-boxes"></i> Stock: <?php echo $product['stock_quantity']; ?>
                        </div>
                        
                        <?php if ($product['description']): ?>
                            <p style="color: #6c757d; font-size: 0.9rem; margin-bottom: 15px;">
                                <?php echo htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : ''); ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="product-actions">
                            <button class="btn btn-primary btn-sm" onclick="editProduct(<?php echo $product['id']; ?>)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="toggleStatus(<?php echo $product['id']; ?>)">
                                <i class="fas fa-toggle-<?php echo $product['is_active'] ? 'on' : 'off'; ?>"></i> 
                                <?php echo $product['is_active'] ? 'Deactivate' : 'Activate'; ?>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Add Product Tab -->
        <div id="add" class="tab-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_product">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php 
                            $categories->data_seek(0);
                            while ($category = $categories->fetch_assoc()): 
                            ?>
                                <option value="<?php echo htmlspecialchars($category['name']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock_quantity">Stock Quantity</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="text" id="weight" name="weight" placeholder="e.g., 2.5 lbs">
                    </div>
                    
                    <div class="form-group">
                        <label for="material">Material</label>
                        <input type="text" id="material" name="material" placeholder="e.g., Leather, Silver">
                    </div>
                    
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" id="color" name="color" placeholder="e.g., Black, Silver">
                    </div>
                    
                    <div class="form-group">
                        <label for="photo">Product Photo</label>
                        <input type="file" id="photo" name="photo" accept="image/*">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter product description..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="Enter tags separated by commas">
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="featured" name="featured">
                        <label for="featured">Featured Product</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </form>
        </div>

        <!-- Manage Categories Tab -->
        <div id="categories" class="tab-content">
            <div class="categories-section">
                <div class="section-header">
                    <h2><i class="fas fa-tags"></i> Product Categories</h2>
                    <button class="btn btn-primary" onclick="showAddCategoryForm()">
                        <i class="fas fa-plus"></i> Add New Category
                    </button>
                </div>
                
                <div class="categories-grid">
                    <?php 
                    $all_categories->data_seek(0);
                    while ($category = $all_categories->fetch_assoc()): 
                        // Count products in this category
                        $product_count_sql = "SELECT COUNT(*) as count FROM products WHERE category = '" . mysqli_real_escape_string($conn, $category['name']) . "' AND client_id = $clientID";
                        $product_count_result = $conn->query($product_count_sql);
                        $product_count = $product_count_result->fetch_assoc()['count'];
                    ?>
                        <div class="category-card">
                            <div class="category-header">
                                <div class="category-icon">
                                    <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                                </div>
                                <div class="category-info">
                                    <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($category['description']); ?></p>
                                </div>
                                <div class="category-status">
                                    <span class="status-badge <?php echo $category['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="category-details">
                                <div class="detail-item">
                                    <i class="fas fa-sort-numeric-up"></i>
                                    <span>Sort Order: <?php echo $category['sort_order']; ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-boxes"></i>
                                    <span>Products: <?php echo $product_count; ?></span>
                                </div>
                            </div>
                            
                            <div class="category-actions">
                                <button class="btn btn-primary btn-sm" onclick="editCategory(<?php echo $category['id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="toggleCategoryStatus(<?php echo $category['id']; ?>)">
                                    <i class="fas fa-toggle-<?php echo $category['is_active'] ? 'on' : 'off'; ?>"></i>
                                    <?php echo $category['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteCategory(<?php echo $category['id']; ?>, <?php echo $product_count; ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Edit Product</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_product">
                <input type="hidden" name="product_id" id="edit_product_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_name">Product Name *</label>
                        <input type="text" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_price">Price *</label>
                        <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_category">Category *</label>
                        <select id="edit_category" name="category" required>
                            <option value="">Select Category</option>
                            <?php 
                            $categories->data_seek(0);
                            while ($category = $categories->fetch_assoc()): 
                            ?>
                                <option value="<?php echo htmlspecialchars($category['name']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_stock_quantity">Stock Quantity</label>
                        <input type="number" id="edit_stock_quantity" name="stock_quantity" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_weight">Weight</label>
                        <input type="text" id="edit_weight" name="weight">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_material">Material</label>
                        <input type="text" id="edit_material" name="material">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_color">Color</label>
                        <input type="text" id="edit_color" name="color">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_photo">New Photo (optional)</label>
                        <input type="file" id="edit_photo" name="photo" accept="image/*">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_tags">Tags</label>
                    <input type="text" id="edit_tags" name="tags">
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="edit_featured" name="featured">
                        <label for="edit_featured">Featured Product</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </form>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-plus"></i> Add New Category</h2>
                <span class="close" onclick="closeAddCategoryModal()">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add_category">
                
                <div class="form-group">
                    <label for="category_name">Category Name *</label>
                    <input type="text" id="category_name" name="category_name" required>
                </div>
                
                <div class="form-group">
                    <label for="category_description">Description</label>
                    <textarea id="category_description" name="category_description" placeholder="Enter category description..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="category_icon">Icon Class *</label>
                    <input type="text" id="category_icon" name="category_icon" placeholder="e.g., fas fa-book" required>
                    <small>Use FontAwesome icon classes (e.g., fas fa-book, fas fa-gem, fas fa-home)</small>
                    <div class="icon-preview" id="iconPreview">
                        <i class="fas fa-question"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="category_sort_order">Sort Order</label>
                    <input type="number" id="category_sort_order" name="category_sort_order" value="0" min="0">
                </div>
                
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Edit Category</h2>
                <span class="close" onclick="closeEditCategoryModal()">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="edit_category">
                <input type="hidden" name="category_id" id="edit_category_id">
                
                <div class="form-group">
                    <label for="edit_category_name">Category Name *</label>
                    <input type="text" id="edit_category_name" name="category_name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_category_description">Description</label>
                    <textarea id="edit_category_description" name="category_description"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_category_icon">Icon Class *</label>
                    <input type="text" id="edit_category_icon" name="category_icon" required>
                    <small>Use FontAwesome icon classes (e.g., fas fa-book, fas fa-gem, fas fa-home)</small>
                    <div class="icon-preview" id="editIconPreview">
                        <i class="fas fa-question"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_category_sort_order">Sort Order</label>
                    <input type="number" id="edit_category_sort_order" name="category_sort_order" min="0">
                </div>
                
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Category
                </button>
            </form>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }

        // Search functionality
        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const name = card.dataset.name;
                const category = card.dataset.category;
                const tags = card.dataset.tags;
                
                if (name.includes(searchTerm) || category.includes(searchTerm) || tags.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Modal functionality
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Edit product
        function editProduct(productId) {
            // Fetch product data and populate form
            fetch(`getProduct.php?id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_product_id').value = data.id;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_price').value = data.price;
                    document.getElementById('edit_category').value = data.category;
                    document.getElementById('edit_stock_quantity').value = data.stock_quantity;
                    document.getElementById('edit_weight').value = data.weight || '';
                    document.getElementById('edit_material').value = data.material || '';
                    document.getElementById('edit_color').value = data.color || '';
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('edit_tags').value = data.tags || '';
                    document.getElementById('edit_featured').checked = data.featured == 1;
                    
                    document.getElementById('editModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading product data');
                });
        }

        // Delete product
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_product">
                    <input type="hidden" name="product_id" value="${productId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Toggle product status
        function toggleStatus(productId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="toggle_status">
                <input type="hidden" name="product_id" value="${productId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }

        // Category management functions
        function showAddCategoryForm() {
            document.getElementById('addCategoryModal').style.display = 'block';
        }

        function closeAddCategoryModal() {
            document.getElementById('addCategoryModal').style.display = 'none';
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').style.display = 'none';
        }

        function editCategory(categoryId) {
            // Fetch category data and populate form
            fetch(`getCategory.php?id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_category_id').value = data.id;
                    document.getElementById('edit_category_name').value = data.name;
                    document.getElementById('edit_category_description').value = data.description || '';
                    document.getElementById('edit_category_icon').value = data.icon;
                    document.getElementById('edit_category_sort_order').value = data.sort_order;
                    
                    // Update icon preview
                    const preview = document.getElementById('editIconPreview');
                    preview.innerHTML = `<i class="${data.icon}"></i>`;
                    
                    document.getElementById('editCategoryModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading category data');
                });
        }

        function deleteCategory(categoryId, productCount) {
            if (productCount > 0) {
                alert(`Cannot delete this category. It has ${productCount} product(s) assigned to it. Please reassign or delete the products first.`);
                return;
            }
            
            if (confirm('Are you sure you want to delete this category?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_category">
                    <input type="hidden" name="category_id" value="${categoryId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function toggleCategoryStatus(categoryId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="toggle_category_status">
                <input type="hidden" name="category_id" value="${categoryId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }

        // Icon preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const iconInput = document.getElementById('category_icon');
            const iconPreview = document.getElementById('iconPreview');
            
            if (iconInput && iconPreview) {
                iconInput.addEventListener('input', function() {
                    const iconClass = this.value.trim();
                    if (iconClass) {
                        iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
                    } else {
                        iconPreview.innerHTML = '<i class="fas fa-question"></i>';
                    }
                });
            }

            const editIconInput = document.getElementById('edit_category_icon');
            const editIconPreview = document.getElementById('editIconPreview');
            
            if (editIconInput && editIconPreview) {
                editIconInput.addEventListener('input', function() {
                    const iconClass = this.value.trim();
                    if (iconClass) {
                        editIconPreview.innerHTML = `<i class="${iconClass}"></i>`;
                    } else {
                        editIconPreview.innerHTML = '<i class="fas fa-question"></i>';
                    }
                });
            }
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const addCategoryModal = document.getElementById('addCategoryModal');
            const editCategoryModal = document.getElementById('editCategoryModal');
            
            if (event.target == editModal) {
                editModal.style.display = 'none';
            }
            if (event.target == addCategoryModal) {
                addCategoryModal.style.display = 'none';
            }
            if (event.target == editCategoryModal) {
                editCategoryModal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
