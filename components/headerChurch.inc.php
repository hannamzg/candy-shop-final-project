<?php
  $backgroundImage = empty($clientInfo['background_img1']) ? '../church/uploads/photo-1492052722242-2554d0e99e3a.avif' : '/church/uploads/' . $clientInfo['background_img1'];
?>
<header class="page-header gradient" id="gradient" style="margin-top: 0; background-image: url('<?php echo $backgroundImage; ?>');">
  <div class="headerTextDiv">
    <div class="animated-element animate__animated animate__rubberBand">
      <?php
        if ($clientID != 1) {
          $DisplayNone = 'display:none;';
          echo '<h1 class="headerText">'.$clientInfo['client_name'].'</h1>';
        }else{
            echo '<h1 class="headerText">  كنيسة القديس جوارجيوس أبوسنان</h1>';
        }
      ?>
    </div>
  </div>
      <?php

          if ($clientID != 1) {
            $sql_content = "SELECT * FROM client_navbar WHERE client_id = $clientID";
            $result_content = $conn->query($sql_content);

            echo '  <ul style="display: flex;margin-top:150px;width: 100%;justify-content: center;gap: 10px;padding: 0; flex-wrap: wrap; ">';

            while ($row = $result_content->fetch_assoc()) {
                $page_link = htmlspecialchars($row['page_link']); 
                $page_name = htmlspecialchars($row['page_name']); 
                echo '<li class="header-item">
                        <a class="header-link" href="' . $page_link . '">' . $page_name . '</a>
                      </li>';
            }
            echo '</ul>';
          }
      ?>
  <ul style="display: flex;margin-top:150px;width: 100%;justify-content: center;gap: 10px;padding: 0; flex-wrap: wrap; <?=$DisplayNone?>">
        <li class="header-item">
            <img src="/img/calendar.png" style="width: 25px;margin-right: 5px;">
            <a class="header-link" href="calender.php">برنامجنا الاسبوعي</a>
        </li>
        <li class="header-item">
            <img src="/img/IconiImage.png" style="width: 25px;margin-right: 5px;">
            <a class="header-link" href="gallery.php">صور</a>
        </li>
        <li class="header-item">
            <img src="/img/question.png" style="width: 25px;margin-right: 5px;">
            <a class="header-link" href="services.php">اسئلة وأجوبة </a>
        </li>
        <li class="header-item">
            <img src="/img/children.png" style="width: 25px;margin-right: 5px;">
            <a class="header-link" href="/SundaySchool.php">اطفال مدرسة الاحد ابوسنان</a>
        </li>
        <li class="header-item">
            <img src="/img/CrossIcon.png" style="width: 25px;margin-right: 5px;">
            <a class="header-link"  href="church.php">شبيبة أبو سنان</a>
        </li>
    </ul>
</header>



<style>
    .headerTextDiv {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.7); /* White background with 50% opacity */
        padding: 10px;
        border-radius: 10px;
    }

    .headerText {
        color: black; /* Text color */
    }

  #gradient{
    position: relative;
    background-image: url(../church/uploads/photo-1492052722242-2554d0e99e3a.avif);
    border-bottom: solid 3px #007bff;
    width: 100%;
    min-height: 400px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position:bottom;
    filter: brightness(95%); 
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  
  .header-item{
    background-color: whitesmoke;
    color: black;
    padding: 5px;
    border-radius: 5px;
    min-width: 120px;
    text-align: center;
    display: flex;
    justify-content: space-around;
  }
  .header-link{
    color: black;

  }
</style>