<?php
session_start();
include '../connect.php';
include '../GetClient.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

// Include the navigation bar
include('../manger/nav.php'); 

// Handle form submission for adding/editing navbar items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $conn->real_escape_string($_POST['client_id']);
    $pageName = $conn->real_escape_string($_POST['page_name']);
    $pageLink = $conn->real_escape_string($_POST['page_link']);
    $displayOrder = (int)$_POST['display_order']; // Cast to int for safety
    $showItem = isset($_POST['show_item']) ? 1 : 0;

    // Insert or update the navbar item based on the presence of an ID
    if (!empty($_POST['id'])) {
        $id = (int)$_POST['id']; // Cast to int for safety
        $sql = "UPDATE client_navbar SET page_name=?, page_link=?, display_order=?, show_item=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $pageName, $pageLink, $displayOrder, $showItem, $id);
    } else {
        $sql = "INSERT INTO client_navbar (client_id, page_name, page_link, display_order, show_item) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issii", $clientId, $pageName, $pageLink, $displayOrder, $showItem);
    }

    if ($stmt->execute()) {
        echo "<p>Navbar item saved successfully!</p>";
    } else {
        echo "<p>Error saving item: " . htmlspecialchars($conn->error) . "</p>";
    }
    $stmt->close();
}

// Fetch current navbar items for the specific client
$sql = "SELECT * FROM client_navbar WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientID);
$stmt->execute();
$result = $stmt->get_result();
$navbarItems = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// Predefined links for the dropdown
$links = [
    '/index.php' => 'main page',
    '/services.php' => 'qs',
    '/gallery.php' => 'gallery',
    '/calender.php' => 'wekly calender',
    '/about.php' => 'about as'
    ]
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Navbar</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Adjust the path -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 4px;
        }
        .navbar {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Navbar Items</h1>

        <form method="POST" action="">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="client_id" value="<?= htmlspecialchars($clientID); ?>">
            <div>
                <label for="page_name">Page Name:</label>
                <input type="text" name="page_name" id="page_name" required>
            </div>
            <div>
                <label for="page_link">Page Link:</label>
                <select name="page_link" id="page_link" required>
                    <option value="">Select a link</option>
                    <?php foreach ($links as $link => $label): ?>
                        <option value="<?= htmlspecialchars($link); ?>"><?= htmlspecialchars($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="display_order">Display Order:</label>
                <input type="number" name="display_order" id="display_order" required>
            </div>
            <div>
                <label for="show_item">Show Item:</label>
                <input type="checkbox" name="show_item" id="show_item" checked>
            </div>
            <button type="submit">Save</button>
        </form>

        <h2>Current Navbar Items</h2>
        <ul>
            <?php foreach ($navbarItems as $item): ?>
                <li>
                    <?= htmlspecialchars($item['page_name']) ?> - 
                    <a href="<?= htmlspecialchars($item['page_link']) ?>"><?= htmlspecialchars($item['page_link']) ?></a> 
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                        <input type="hidden" name="client_id" value="<?= htmlspecialchars($clientID); ?>">
                        <button type="button" onclick="editItem(<?= $item['id']; ?>, '<?= addslashes($item['page_name']); ?>', '<?= addslashes($item['page_link']); ?>', <?= $item['display_order']; ?>, <?= $item['show_item']; ?>)">Edit</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        
    </div>

    <script>
        function editItem(id, pageName, pageLink, displayOrder, showItem) {
            document.getElementById('id').value = id;
            document.getElementById('page_name').value = pageName;
            document.getElementById('page_link').value = pageLink;
            document.getElementById('display_order').value = displayOrder;
            document.getElementById('show_item').checked = showItem === 1;
        }
    </script>
</body>
</html>
