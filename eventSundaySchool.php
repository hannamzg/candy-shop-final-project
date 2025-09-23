<?php require('components/head.inc.php'); ?>
<?php include('components/navbar.inc.php'); ?>
<?php
 require('connect.php');

    $pageID = $conn->real_escape_string($_GET['id']);

    // Fetch page content
    $query = "SELECT * FROM `content` WHERE `id` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pageID);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Fetch slider images
    $imageQuery = "SELECT * FROM `mainsilderimg` WHERE `page` = ?";
    $imgStmt = $conn->prepare($imageQuery);
    $imgStmt->bind_param("i", $pageID);
    $imgStmt->execute();
    $imageResult = $imgStmt->get_result();
    $images = [];
    while ($imgRow = $imageResult->fetch_assoc()) {
        $images[] = $imgRow;
    }

    $stmt->close();
    $imgStmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautiful Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <script src="../js/bootstrap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
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
        
        main {
            padding: 20px;
        }
        
        .cardPage {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .cardPage img {
            max-width: 100%;
            height: auto;
            width: 100%;
            max-width: 400px;
            max-height: 200px;
        }
        
        .card-content {
            padding: 20px;
            max-width: 50%;
            width: 50%;
            direction: rtl;
        }
        
        .card-content h2 {
            margin-bottom: 10px;
        }
        
        .card-content p {
            line-height: 1.6;
            height: auto;
        }

        @media only screen and (max-width: 600px) {
            .card-content {
                max-width: 100%;
                width: 100%;
            }
            .cardPage{
              flex-direction: column-reverse;
            }
        }

        swiper-container {
          width: 50%;
          height: 100%;
        }

        swiper-slide {
          text-align: center;
          font-size: 18px;
          background: #fff;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        swiper-slide img {
          display: block;
          width: 100%;
          height: 100%;
          object-fit: cover;
        }
        swiper-container {
            min-width: 350px;
            height: 350px;
            direction: rtl;
        }
        
        swiper-slide {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          position: relative;
          overflow: hidden;
          border-radius: 10px; /* Rounded corners */
          background-size: cover;
          background-position: center;
        }
    </style>
</head>
<body>
   
    <header>
        <h1><?=$data[0]['title']?></h1>
    </header>
    <main>
        <div id="content-container">
            <?php foreach ($data as $item): ?>
                <div class="cardPage">
                    <swiper-container class="mySwiper" navigation="true">
                        <?php foreach ($images as $image): ?>
                            <?php $imageUrl = '/church/uploads/' . $image['img']; ?>
                            <swiper-slide style="background-image: url('<?=$imageUrl?>');"></swiper-slide>
                        <?php endforeach; ?>
                    </swiper-container>
                    <div class="card-content">
                        <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
<?php require('components/footer.inc.php'); ?>
</html>
