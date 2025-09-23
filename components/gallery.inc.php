    <section class="gallery">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 160">
        <path
          fill="#fff"
          fill-opacity="1"
          d="M0,128L120,128C240,128,480,128,720,122.7C960,117,1200,107,1320,101.3L1440,96L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z"
        ></path>
      </svg>
      <div class="container">
        <div class="row">
          <div class="col-md-10" style="direction: rtl;">
              
            <?php
                require('./connect.php');
                require('./GetClient.php');

                $sql = "SELECT * FROM `content` WHERE content.pageID = 2 AND client_id = $clientID";
            
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<h1>".$row['title']."</h1>";
                    echo "<p>".$row['content']."</p>";
                }
            ?>
          </div>
        </div>
        <div class="row my-3 g-3">
        <?php

            $sql = "SELECT * FROM `mainsilderimg` WHERE client_id = $clientID";

            $result = $conn->query($sql);

            if ($result === FALSE) {
                // Error handling
                die("Error: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                $c = 0;
                while ($row = $result->fetch_assoc()) {
                  echo '<div class="col-md-4">
                          <img src="../church/uploads/' . $row['img'] . '" alt="Gallery image" class="img-fluid" />
                        </div>';
                }
            }   
          ?>
        </div>
        
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path
          fill="#fff"
          fill-opacity="1"
          d="M0,128L120,128C240,128,480,128,720,122.7C960,117,1200,107,1320,101.3L1440,96L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"
        ></path>
      </svg>
    </section>