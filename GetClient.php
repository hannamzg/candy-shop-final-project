<?php
require('connect.php');

// Get the domain name from the server variables
$domain = $_SERVER['HTTP_HOST'];

// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM `clients` WHERE domin = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $domain);
$stmt->execute();
$result = $stmt->get_result();

// Initialize clientID variable
$clientID = null;

// Check if a client was found and set the client ID
if ($row = $result->fetch_assoc()) {
    $clientID = $conn->real_escape_string($row['id']); 
} else {
    echo "No client found for the domain: " . htmlspecialchars($domain);
    exit(); // Exit if no client is found
}

// Close the statement for the first query
$stmt->close();

// Initialize clientInfo array
$clientInfo = [];

// If a clientID was found, retrieve additional information
if ($clientID !== null) {
    // Query the general_elements table for additional data
    $sql = "SELECT * FROM `general_elements` WHERE ClientID = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any data was returned
    if ($row = $result->fetch_assoc()) {
        // Use real_escape_string to sanitize the data
        $clientInfo = [
            'id' => $conn->real_escape_string($row['id']),
            'ClientID' => $conn->real_escape_string($row['ClientID']),
            'client_name' => $conn->real_escape_string($row['client_name']),
            'phone' => $conn->real_escape_string($row['phone']),
            'facebook' => $conn->real_escape_string($row['facebook']),
            'icon' => $conn->real_escape_string($row['icon']),
            'background_img1' => $conn->real_escape_string($row['background_img1']),
            'background_img2' => $conn->real_escape_string($row['background_img2']),
            'background_img3' => $conn->real_escape_string($row['background_img3']),
            'title_page2' => $conn->real_escape_string($row['title_page2']),
            'title_page3' => $conn->real_escape_string($row['title_page3']),
            'description' => $conn->real_escape_string($row['description']),
            'lang' => $conn->real_escape_string($row['lang']),
        ];
    } 

    // Close the statement for the second query
    $stmt->close();
}
?>
