<?php
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
      if ($clientInfo['id'] == 2) {
        echo '<meta name="keywords" content="נגרייה, עיצוב מטבחים, מטבחים בהתאמה אישית, נגרות אישית">';
        echo "in ";
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