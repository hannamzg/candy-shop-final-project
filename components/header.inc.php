<header class="page-header gradient" id="gradient" style="margin-top: 0 " >
  <div class="headerTextDiv">
    <div class="animated-element animate__animated animate__rubberBand">
      <h1 class="headerText">شبيبة أبوسنان</h1>    
    </div>
  </div>
  <ul style="display: flex;margin-top:150px;width: 100%;justify-content: center;gap: 10px;padding: 0; display:none;    flex-wrap: wrap;">
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
            <a class="header-link" href="services.php">لعبه اساله</a>
        </li>
        <li class="header-item">
            <img src="/img/CrossIcon.png" style="width: 25px;margin-right: 5px;">
            <a class="header-link"  href="church.php">شبيبه ابو سنان</a>
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
    background-image: url('../img/Cross-Background.jpg');

    width: 100%;
    min-height: 400px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
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