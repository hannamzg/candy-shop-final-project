<div class="container" style="direction: rtl;">
  <h2 style="font-family: Arial, sans-serif; color: #333;  margin: 20px auto;">فعاليات الشبيبة</h2>

  <!-- Swiper container -->
  <swiper-container class="mySwiper" space-between="30" slides-per-view="auto" pagination="true" pagination-clickable="true">
    <?php
    // Fetch content from the database
    $sql = "SELECT * FROM `content` WHERE pageID = 3 AND client_id = $clientID ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imageUrl = '/church/uploads/' . $row['img'];

            // Echo each Swiper slide
            echo '<swiper-slide style="width: 300px;">
                    <div class="card" style="width: 100%; margin: 10px; background: white; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                        <img class="card-img-top" src="' . htmlspecialchars($imageUrl) . '" alt="Card image cap" style="width: 100%; height: 180px; object-fit: cover;">
                        <div class="card-body" style="padding: 15px;">
                            <h5 class="slide-title" style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">' . htmlspecialchars($row['title']) . '</h5>
                            <p class="card-text" style="margin-bottom: 15px;">' . htmlspecialchars($row['description']) . '</p>
                            <a href="eventYouth.php?id=' . $row['id'] . '" class="btn" style="display: inline-block; padding: 10px 15px; font-size: 14px; color: white; background-color: #007bff; border: none; border-radius: 5px; text-decoration: none; text-align: center;">المزيد من المعلومات</a>
                        </div>
                    </div>
                  </swiper-slide>';
        }
    } else {
        echo '<p>No content available.</p>';
    }
    ?>
  </swiper-container>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

<style>
  .swiper-container {
    width: 100%;
    height: auto;
  }

  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .btn:hover {
    background-color: #0056b3;
  }

  .card {
    text-align: right; 
  }
</style>
