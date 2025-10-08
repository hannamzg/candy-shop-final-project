<?php
session_start();
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

include '../connect.php';
include '../GetClient.php';

if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);
    
    $sql = "SELECT * FROM product_categories WHERE id = $categoryId AND client_id = $clientID";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $category = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($category);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Category not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Category ID required']);
}
?>
