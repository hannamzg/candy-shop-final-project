    <?php
      if ($clientID != 1) {
        $DisplayNone = 'display:none;';
        echo '<footer style="padding: 20px; background-color: #000; color: #ffffff; border-top: 1px solid #007bff; text-align: center;">
                  <div>
                      <h3>צור קשר</h3>
                      <p>טלפון: <a href="tel:+0525119685" style="text-decoration: none !important; color: white !important;">0525119685</a></p>
                      <p>אימייל: <a href="mailto:elimzghanna123@gmail.com" style="text-decoration: none !important; color: white !important;">elimzghanna123@gmail.com</a></p>
                      <p>פייסבוק: <a href="https://www.facebook.com/elimzigit" target="_blank" style="text-decoration: none !important; color: white !important;">עמוד פייסבוק</a></p>
                  </div>
                  <div style="margin-top: 20px;max-width: 100%;">
                      <h3 >מיקום שלנו</h3>
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3347.7724630538537!2d35.1682306!3d32.95701630000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151dcc61a08da46d%3A0xb9c18fc46c6841ad!2s166%2C%20Abu%20Snan!5e0!3m2!1sen!2sil!4v1729623918141!5m2!1sen!2sil" width="600" height="450" style="border:0; max-width:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                  <p style="color: #ffffff;">&copy; 2024 כל הזכויות שמורות</p>
              </footer>
              ';
      }
    ?>
    <footer class="gradient" style="background: black; position: absolute;width: 100%; <?=$DisplayNone?> ">
      <ul class="navFooter" style="<?=$DisplayNone?>">
            <li>
              <a href="index.php">الصفحه الرئيسيه</a>
            </li>
            <li>
              <a href="church.php">شبيبة أبو سنان</a>
              <img src="/img/CrossIcon.png" style="width: 25px;margin-right: 5px;">
            </li>
            <li>
              <a href="/SundaySchool.php">اطفال مدرسة الاحد ابوسنان</a>
              <img src="/img/children.png" style="width: 25px;margin-right: 5px;">
            </li>
            <li>
              <a href="services.php">اسئلة وأجوبة</a>
              <img src="/img/question.png" style="width: 25px;margin-right: 5px;">
            </li>
            <li>
              <a href="gallery.php">صور</a> 
              <img src="/img/IconiImage.png" style="width: 25px;margin-right: 5px;">
            </li>
            <li>
              <a href="calender.php">برنامجنا الاسبوعي</a>
              <img src="/img/calendar.png" style="width: 25px;margin-right: 5px;">
            </li>
        </ul>
        <div class="container-fluid text-center">
            <span>Made by <a href="">Hanna Mzeget</a></span>
        </div>
    </footer>
    <style>
        .navFooter{
            direction: rtl; 
            display: flex; 
            justify-content:center;
            flex-wrap: wrap; 
            gap:10px;
            width:100%;
        }
        
        .navFooter li{
            display: flex;
            justify-content:center;
            gap:5px;
            background:white;
            padding:5px;
            border-radius:5px;
            width:100%;
            max-width:250px;
        }
        
        .navFooter li a{
            color:black;
        }
    </style>
  </body>
</html>