<?php
    require('connect.php');
?>
<div>
    <div class="welcomTextDiv">
        <?php
            $sql = "SELECT * FROM `content` WHERE pageID = 7 LIMIT 1"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h2 style='font-size: 35px;'>".$row['title']."</h2>";
                    echo "<p style='margin-top: 15px;padding: 20px; font-size: 20px;'>".$row['content']."</p>";
                }
            } 
        ?>


    </div>
</div>




<?php include('sliderSundaySchool.php'); ?>
<br>
<style>
    .midMainDiv{
        display: flex;
        width: 100%;
        border-top: 1px solid;
        border-bottom: 1px solid;
    }

    .midDiv1{
       background-image: url(../img/OIG2.84xOLuE.jpg);
       width: 50%;
       min-height: 350px;
       background-size: cover;
       background-repeat: no-repeat;
       background-position: center center;
       filter: brightness(95%);
       display: flex;
       justify-content: center;
       align-items: center;
       flex-direction: column;
    }
    .midDiv2{ 
       background-color: rgb(230 230 230 / 70%); 
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

    .welcomTextDiv{
        text-align: center;
        margin: 20px auto;
        padding: 10px;
    }
    

</style>