<style>
    .containerClassButtons {
        display: flex;
        justify-content: space-around;        
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 800px; /* Limit the width for better layout */
    }

    .circleClassButtons {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: #ffffff;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
        color: #333333;
        font-size: 15px; /* Adjusted font size */
        text-transform: uppercase;
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        overflow: hidden; /* Hide overflow */
        text-overflow: ellipsis; /* Ellipsis for overflow text */
        font-weight: bolder;
        padding: 10px;
        text-align: center;
    }

    .circleClassButtons:hover {
        transform: scale(1.1);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    }

    a {
        text-decoration: none; /* Remove underline from links */
    }
</style>

<div class="containerClassButtons">
    <?php
    
        $sql = "SELECT * FROM `class` WHERE client_id = $clientID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<a href="/ClassPage.php?id=' . $row['id'] . '&title=' . $row['title'] . '">
                        <div class="circleClassButtons">' . $row['title'] . '</div>
                      </a>';
            }
        } else {
            echo "No classes available.";
        }
    ?>
</div>

