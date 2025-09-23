<?php
    require('connect.php');
    require('GetClient.php');
    $icon = empty($clientInfo['icon']) ? 'img/CrossIcon.png' : '/church/uploads/' . $clientInfo['icon'];

?>



<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?=$icon?>" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <?php
      if ($clientID == 2) {
        echo '<meta name="keywords" content="נגרייה, עיצוב מטבחים, מטבחים בהתאמה אישית, נגרות אישית">';
        echo '<script type="application/ld+json">
                {
                "@context": "https://schema.org",
                "@type": "LocalBusiness",
                "name": "נגרייה אלי מזיגית",
                "description": "עיצוב וייצור מטבחים ואורנות מותאמים אישית",
                "image": "/church/uploads/20241022155553_ICON1.png",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "166",
                    "addressLocality": "אבו סנאן כפר יאסיף",
                    "postalCode": "24905",  // Replace with the exact postal code if this is not accurate
                    "addressCountry": "IL"
                },
                "telephone": "0502121861",
                "url": "https://mzeget.site/"
                }
            </script>';
      }
    ?>
    <meta name="description" content="<?=$clientInfo['description']?>">
    <meta name="author" content=" <?=$clientInfo['description']?> " />
    <title> <?=$clientInfo['client_name']?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="js/bootstrap.min.js" defer></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
<?php include('components/navbar.inc.php'); ?>
<?php include('components/headerChurch.inc.php');?>
<?php include('components/indexHeader.inc.php');?>
<?php include('components/classButtons.inc.php'); ?>
<div class="midMainDiv">
    <?php
        require('GetClient.php');
        $sql = "SELECT * FROM `content` WHERE pageID = 5 AND client_id = $clientID LIMIT 1"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title5 = $row['title'];
                $content5 = $row['content'];
                $img = $row['img'];
            }
        } 
        $midDiv1BackgroundImg = $clientID == 1 ? '../img/churchSecoundbackgroundimg.jpg' : '/church/uploads/' . $img;
    ?>
    <div class="midDiv1" style="background-image: url(<?=$midDiv1BackgroundImg?>);"></div>
    <div class="midDiv2">
        <?php
            $sql = "SELECT * FROM `content` WHERE pageID = 5 AND client_id = $clientID LIMIT 1"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h3>".$title5."</h3>";
                    echo "<p>".$content5."</p>";
                }
            } 
        ?>
    </div>
</div>

<div class="facebookDiv">
    <?php
        $sql = "SELECT * FROM `content` WHERE pageID = 6 AND client_id = $clientID"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['content'];
                echo '<div class="borderDiv"></div>';
                echo "<h2>".$row['title']."</h2>";
            }
        } 
        if ($clientID !=1 ) {
            $displayNone = 'display:none;';
        }
    ?>
</div>

<?php
    $mainSilderimgPage = '1';
    echo '<div style="display: flex;
                      justify-content: center;
                      align-items: center;
                      flex-direction: column; ">';
    if ($clientID == 1) {
        echo "<h1 style='text-align: center;text-shadow: 1px 1px 3px rgba(128, 128, 128, 1);'>صور</h1>";

    }else{
        echo "<h1 style='text-align: center;text-shadow: 1px 1px 3px rgba(128, 128, 128, 1);'>תמונות</h1>";
    }
    echo '<div class="borderDiv"></div>';
    echo '</div>';
    require('components/SwiperImgs.php');
    echo '<br/>';

?>

<section id="instagram-feed" style="margin: 40px auto;
                                    display: flex;
                                    justify-content: center;
                                    flex-direction: column;
                                    align-items: center; <?=$displayNone ?>">
    <h3 style="
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline;
            ">
        facebook
    </h3>        
    
    <div class="fb-page" 
        data-href="https://www.facebook.com/abusnanchurch" 
        data-tabs="timeline" 
        data-width="310" 
        data-height="500" 
        data-small-header="false" 
        data-adapt-container-width="true" 
        data-hide-cover="false" 
        data-show-facepile="true">
    </div>
    <script async defer crossorigin="anonymous" 
            src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0">
    </script>
    <a href="https://www.facebook.com/abusnanchurch" target="_blank">Visit our Facebook Page</a>
</section>

<style>
    .midMainDiv{
        display: flex;
        width: 100%;
        border-top: 1px solid;
        border-bottom: 1px solid;
    }
    .midDiv1{ 
       width: 50%;
       height: 350px;
       background-image: url('../img/churchSecoundbackgroundimg.jpg');
       background-position: bottom;
       background-size: cover;
       object-fit: cover;
       display: flex;
       align-items: center;
       justify-content: center;
    }
    .midDiv2{ 
       background-color: rgb(230 230 230 / 70%); /* White background with 50% opacity */
       width: 50%;
       height: 350px;
       direction: rtl;

    }
    .midDiv2 h3{
       text-align: center;
       margin: 20px;
    }
    .midDiv2 p{
      padding:13px;
    }
    @media only screen and (max-width: 600px) {
        .midMainDiv{
            flex-direction: column-reverse;
        }
        .midDiv1{ 
           width: 100%;
        }
        .midDiv2{ 
           width: 100%;
        }
        .facebookIframe{
            width:100%;
        }
    }
    
    body{
        background-color: rgba(255, 255, 255, 0.7); /* White background with 50% opacity */
    }
    
    .headerTextDiv {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.7); /* White background with 50% opacity */
        padding: 10px;
        border-radius: 10px;
        width: fit-content;
        margin: 0 auto;
    }

    .headerText {
        color: black; /* Text color */
    }
    
    .welcomTextDiv{
        text-align: center;
        margin: 20px auto;
        padding: 10px;
    }
    
    .facebookDiv{
        margin-top: 50px;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column-reverse;
        
    }
    
    .facebookDiv iframe{
        border: none;
        overflow: hidden;
        max-width: 100%;
    }
    
    .facebookDiv h2{
        text-align: center;
        text-shadow: 1px 1px 3px rgba(128, 128, 128, 1);
    }
    
    .borderDiv{
        border-bottom: 10px solid black;
        height: 10px;
        border-radius: 100px;
        margin-bottom: 50px;
        margin-top: 10px;
        width:80px;
    }
    
    .borderDiv:hover{
        width: 120px;
        transition:  1s ease-in-out;    
    }
    .fb-page {
        max-width: 310px; /* Adjust as needed */
        width: 100%;
        height: auto; /* Optional: Allows height to adjust based on content */
    }

</style>


<?php require('components/footer.inc.php'); ?>


