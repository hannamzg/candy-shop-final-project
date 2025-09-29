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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 50px;
    }

    .page-header h1 {
        font-size: 3rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .page-header p {
        font-size: 1.2rem;
        margin: 15px 0 0;
        opacity: 0.9;
    }

    .breadcrumb-nav {
        background: rgba(255,255,255,0.1);
        padding: 15px 0;
        margin-top: 30px;
    }

    .breadcrumb-nav a {
        color: #fff;
        text-decoration: none;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .breadcrumb-nav a:hover {
        opacity: 1;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    #content-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        padding: 20px 0 60px;
    }

    .card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }

    .card-body {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .card-text {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #dee2e6;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #495057;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin: 0;
    }

    .back-button {
        position: fixed;
        top: 20px;
        left: 20px;
        background: rgba(255,255,255,0.9);
        color: #667eea;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .back-button:hover {
        background: #667eea;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }
        
        #content-container {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .back-button {
            position: relative;
            top: auto;
            left: auto;
            margin: 20px;
            display: inline-block;
        }
    }
</style>

<?php include('components/navbar.inc.php'); ?>

<body>
    <a href="index.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-star"></i> <?= htmlspecialchars($title) ?></h1>
            <p>Explore our programs and activities</p>
            <div class="breadcrumb-nav">
                <a href="index.php">Home</a> / 
                <a href="index.php#services">Services</a> / 
                <span><?= htmlspecialchars($title) ?></span>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="content-container">
            <?php
            $sql = "SELECT id, title, content, img, link, linkText FROM classpage WHERE ClassID = $pageID ORDER BY priority ASC, id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $img = !empty($row["img"]) ? '<img src="/church/uploads/' . htmlspecialchars($row["img"]) . '" class="card-img-top" alt="' . htmlspecialchars($row["title"]) . '">' : '<div class="card-img-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;"><i class="fas fa-image"></i></div>';
                    $link = !empty($row["link"]) ? htmlspecialchars($row["link"]) : '#';
                    $linkText = !empty($row["linkText"]) ? htmlspecialchars($row["linkText"]) : 'Learn More';
                    
                    echo '<div class="card">
                            ' . $img . '
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row["title"]) . '</h5>
                                <p class="card-text">' . htmlspecialchars($row["content"]) . '</p>
                                <a href="' . $link . '" class="btn btn-primary" target="' . (!empty($row["link"]) ? '_blank' : '_self') . '">
                                    <i class="fas fa-arrow-right"></i> ' . $linkText . '
                                </a>
                            </div>
                          </div>';
                }
            } else {
                echo '<div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No Programs Available</h3>
                        <p>We are working on adding programs to this category. Please check back soon!</p>
                      </div>';
            }
            ?>
        </div>
    </div>

    <?php require('components/footer.inc.php'); ?>
</body>

</html>
