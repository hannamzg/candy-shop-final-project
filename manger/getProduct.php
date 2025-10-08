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
    $productId = intval($_GET['id']);
    
    $sql = "SELECT * FROM products WHERE id = $productId AND client_id = $clientID";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Product ID required']);
}
?>
