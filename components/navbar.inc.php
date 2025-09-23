
<?php
  require('GetClient.php');
  $icon = empty($clientInfo['icon']) ? 'img/CrossIcon.png' : '/church/uploads/' . $clientInfo['icon'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="position: sticky !important;">
  <div class="container">
    <a class="navbar-brand" href="/"><img src="<?=$icon?>" alt="" style="height: 70px;" /></a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div
      class="collapse navbar-collapse justify-content-end"
      id="navbarNav"
    >
      <?php

          if ($clientID != 1) {
            $DisplayNone = 'display:none;';
            $sql_content = "SELECT * FROM client_navbar WHERE client_id = $clientID ORDER By display_order";
            $result_content = $conn->query($sql_content);

            echo '<ul class="navbar-nav" style="direction: rtl;">';

            while ($row = $result_content->fetch_assoc()) {
                $page_link = htmlspecialchars($row['page_link']); 
                $page_name = htmlspecialchars($row['page_name']); 
                echo '<li class="nav-item">
                        <a class="nav-link" href="' . $page_link . '">' . $page_name . '</a>
                      </li>';
            }
            echo '</ul>';
          }
      ?>
      <ul class="navbar-nav" style="direction: rtl; <?=$DisplayNone?>">
        <li class="nav-item">
          <a class="nav-link"  href="/index.php">الصفحة الرئيسية</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/church.php">شبيبة أبو سنان</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/SundaySchool.php">اطفال مدرسة الاحد ابوسنان</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/services.php">أسئلة وأجوبة </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gallery.php">صور</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/calender.php">برنامجنا الاسبوعي</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
  if ($clientInfo['phone']) {
    echo '<a href="tel:'.$clientInfo['phone'].'" id="whatsapp-icon" target="_blank">                    
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
          </a>';
  }
?>
<style>
  .nav-link{
    font-size: large;
  }
  #whatsapp-icon {
    position: fixed;
    bottom: 20px; 
    right: 20px; 
    z-index: 1000; 
  }

  #whatsapp-icon img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
  }
</style>
