<?php

if (isset($_GET['logout'])) {
    unset($_SESSION['adminUserName']);

    session_destroy();

    header("Location: LogInToAdmin.php");
    exit();
}

session_start();
// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}
?>



<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    nav {
        background-color: #333;
        overflow: hidden;
    }

    nav a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    nav a:hover {
        background-color: #ddd;
        color: black;
    }

    @media (max-width: 600px) {
        nav a {
            float: none;
            display: block;
            text-align: left;
        }
    }
</style>
<link rel="icon" href="http://localhost/church/church/img/CrossIcon.png">
<meta name="robots" content="noindex, nofollow">

<nav>
    <a href="../manger/index.php">Home</a>
    <a href="../manger/AddToMainImgSilder.php">Add to main silder img </a>
    <a href="../manger/AddToQuestions.php">Add to main AddToQuestions </a>
    <a href="../manger/mangeText.php">Add to main mangeText </a>
    <a href="../manger/classMange.php">Add to Class Page </a>
    <a href="../manger/addAndDeleteClass.php">add And Delete Class </a>
    <a href="../manger/calendarMange.php">calendarMange</a>
    <a href="../manger/SetClientNavbar.php">SetClientNavbar</a>
    <a href="../manger/SetGeneral.php">SetGeneral</a>
    <a href="/index.php">Main website</a>
    <a href="?logout" style="float: right; color: red;">Logout</a>
</nav>