<?php
require('connect.php');
$pageID = $conn->real_escape_string($_GET['id']);
$title  = $conn->real_escape_string($_GET['title']);
?>
<!DOCTYPE html>
<html lang="en">

<?php require('components/head.inc.php'); ?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    #content-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }

    .card {
        width: 18rem;
        display: flex;
        flex-direction: column;
    }

    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-text {
        height: 3rem; /* Adjust as needed */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Number of lines to show */
        -webkit-box-orient: vertical;
    }
    .card-img, .card-img-bottom, .card-img-top{
        height: 200px;
    }
    @media only screen and (max-width: 600px) {
        .card {
            width: 100%;
        }
    }
</style>

<?php include('components/navbar.inc.php'); ?>

<body>

    <header>
        <h1><?= $title ?></h1>
    </header>
    <main style="min-height: 100vh;">
        <div id="content-container">
            <?php
            $sql = "SELECT id, title, content, img, link, linkText FROM classpage WHERE ClassID = $pageID ORDER BY priority";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $img = !empty($row["img"]) ? '<img src="/church/uploads/' . htmlspecialchars($row["img"]) . '" class="card-img-top" alt="Image">' : '';
                    $link = !empty($row["link"]) ? htmlspecialchars($row["link"]) : 'page.php?id=' . $row['id'];
                    
                    echo '<div class="card">
                            ' . $img . '
                            <div class="card-body text-center">
                                <h5 class="card-title">' . htmlspecialchars($row["title"]) . '</h5>
                                <p class="card-text">' . htmlspecialchars($row["content"]) . '</p>
                                <a href="' . $link . '" class="btn btn-primary">' . htmlspecialchars($row["linkText"]) . '</a>
                            </div>
                          </div>';
                }
            }
            ?>
        </div>
    </main>
    <?php require('components/footer.inc.php'); ?>
    <script src="script.js"></script>
</body>

</html>
