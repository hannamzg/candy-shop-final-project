<?php
      require('connect.php');
?>
<div id="blurBackground" class="blur-background">
    <div class="blur-content">
        <button id="closeBlur">x</button>
    </div>
    <div style="background-color: white;width: fit-content;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                border-radius: 10px;
                                padding: 50px;
                                border-bottom: solid 3px #007bff;" id="blur-background">
        <?php
            $sql = "SELECT * FROM `content` WHERE pageID = 4 "; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h1 style='border-bottom: 1px solid;'>".$row['title']."</h1>";
                    echo "<p style='padding: 10px;text-align: center;'>".$row['content']."</p>";
                    echo '<img src="/church/uploads/' . $row['img'] . '"    class="imgStartt">';
                }
            }
        ?>
    </div>
</div>

<section class="churchSlider">
    <div class="churchInfo" style="display: flex; margin: 20px auto;justify-content: center; ">
        <div  class="iconsMainBigDiv">
            <div class="iconsMainDiv">
                <div class="animated-element animate__animated animate__fadeInDownBig">
                    <img src="/img/christianity.png" alt="" class="iconsMain">
                </div>
            </div>
            <div class="iconsMainDiv">
                <img src="/img/bible.png" alt="" class="iconsMain">
            </div>
        </div>
        <div style="direction: rtl; margin:10px; text-align: center;"> 
        <?php
      

            $sql = "SELECT * FROM `content` WHERE pageID = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h1>".$row['title']."</h1>";
                    echo "<p>".$row['content']."</p>";
                    echo '<a href="' . $row['link'] . '" class="btn btn-primary" style="margin: 10px 0; width: 100%; max-width: 200px;">' . $row['linkText'] . '</a>';
                    echo '<img src="/church/uploads/' . $row['img'] . '" class="imgStart">';
                }
            } else {
                echo "No results found.";
            }
        ?>

        </div>
        <div  class="iconsMainBigDiv">
            <div class="iconsMainDiv">
                <div class="animated-element animate__animated animate__fadeInDownBig">
                    <img src="/img/CrossIcon.png" alt="" class="iconsMain">
                </div>
            </div>
            <div class="iconsMainDiv">
                <img src="/img/praying.png" alt="" class="iconsMain">
            </div>
        </div>
       
    </div>

</section>

<div class="ss" style="direction: rtl; display:none" >
        <?php

            $sql = "SELECT * FROM `content` WHERE content.pageID = 3";
            
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<h2 style='margin:40px;'>".$row['title']."</h2>";
                echo '<ul>
                        <li class="event">
                            <div class="event-title">'.$row['content'].'</div>
                            <img src="/church/uploads/' . $row['img'] . '"  class="imgInEvent">
                        </li>

                    </ul>';
            }
        ?>
</div>
<?php
    require('sliderYouth.php'); 
?>
<section id="instagram-feed" style="margin: 40px auto;
                                    display: flex;
                                    justify-content: center;
                                    flex-direction: column;
                                    align-items: center;">
        <h3 style="background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                display: inline;">
            instagram
        </h3>        
        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/orthodox_youth_abusinan/" data-instgrm-version="13" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"></blockquote>
        <script async src="//www.instagram.com/embed.js"></script>
</section>
<!-- <div class="slider-controls">
    <button class="prev-btn">Previous</button>
    <button class="next-btn">Next</button>
</div> -->





<style>
    ul{
        list-style: none;
    }
    .ss{
        width: 100%;
    }
    @media only screen and (max-width: 600px) {
        .event {
           
            justify-content: center !important;
        }
        .imgStart{
            max-width: 350px !important;
        }
        .imgStartt{
            max-width: 250px !important;
        }
        .imgInEvent{
            max-width: 250px !important;
            height: auto;
            max-height:300px !important;
        }
        .iconsMainBigDiv{
            display: flex;
            flex-direction: row !important;
            justify-content: center !important;

       
        }
        .slide{
            width: 90% !important;
            height: 250px !important;
        }
        .churchInfo{
            flex-direction: column;

        }
        .iconsMain{
            width: 50px;
            height: 50px;

        }
        .event-title {
            width: 100% !important;
        }
    }
    .imgStart{
        max-width: 500px;
    }
    .imgStartt{
        max-width: 500px;
    }
    .iconsMainBigDiv{
            display: flex;
            flex-direction: column;
            justify-content: space-around;

    }
    .iconsMainDiv{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: whitesmoke;
        width: 150px;
        height: 150px;
        margin: 10px;
    }

    .iconsMain{
        width: 100px;
        height: 100px;
    }

    .churchSlider {
        max-width: 800px;
        margin: 0 auto;
    }

    .slider-container {
        position: relative;
    }

    .slider {
        width: 100%;
        overflow: hidden;
        position: relative;
        margin: 0 auto;
    }

    .slide {
        width: 100%;
        width: 800px;
        height: auto;
        max-height: 400px;
        display: none;    
        margin: 0 auto;
    }

    .slide.active {
        display: block;
    }

    .slider-controls {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .prev-btn{
        background-color: #333;
        color: #fff;
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        margin: 0 5px;
        position: relative;
        right: 0;
    }
    .next-btn {
        background-color: #333;
        color: #fff;
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        margin: 0 5px;
        position: relative;
        left: 0;
    }

    .prev-btn:hover,
    .next-btn:hover {
        background-color: #555;
    }
    .event {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .event-date {
            font-weight: bold;
            color: #666;
        }
        .event-title {
            margin-top: 5px;
            font-size: 18px;
            color: #333;
            width: 50%;
            padding:10px;
        }
        .event-description {
            margin-top: 5px;
            color: #555;
        }
        .event:hover {
            background-color: #e9e9e9;
            transition: background-color 0.3s ease;
        }
        .imgInEvent{
            max-width: 40%;
            height: auto;
            border-radius: 15px;
            max-height:300px !important;
        }
        .blur-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999999;
        }
        
        .blur-content {
            text-align: center;
        }
        
        #closeBlur {
                position: absolute;
                top: 10px;
                right: 15px;
                cursor: pointer;
                color: white;
                background-color: rgba(0, 0, 0, 0.5);
                background-color: red;
                font-size: 28px;
                border: none;
                padding: 5px 20px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: end;
        }

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const iconsMainDivs = document.querySelectorAll(".iconsMainDiv");
        const blurBackground = document.getElementById("blurBackground");
        const closeBtn = document.getElementById("closeBlur");
        const blurBackgroundDiv = document.getElementById("blur-background");

        function closeBlurBackground() {
            blurBackground.style.display = 'none';
        }

        iconsMainDivs.forEach((div) => {
            div.addEventListener("click", function () {
                blurBackground.style.display = "flex";
            });
        });

        blurBackground.addEventListener('click', function (event) {
            if ((event.target === blurBackground || event.target === closeBtn) ) {
                closeBlurBackground();
            }
        });

        closeBtn.addEventListener("click", function () {
            closeBlurBackground();
        });
    });
</script>
