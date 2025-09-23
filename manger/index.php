<?php
 session_start();
 if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
     header("Location: LogInToAdmin.php");
     exit();
 }

include '../connect.php'; // Include your database connection file

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://localhost/church/church/img/CrossIcon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .card {
            margin: 10px;
        }

        .modal-body {
            overflow-y: auto;
        }
    </style>
    <title>Product Management</title>
</head>

<body>

    <?php include('../manger/nav.php'); ?>

    <!-- Display products and buttons -->


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
