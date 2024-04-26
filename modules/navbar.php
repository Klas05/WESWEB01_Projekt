<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skivor AB</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>

  <nav>
    <?php

    /**
     * Fixar så att aktuell 
     */

    require_once __DIR__ . "/../functions/functions.php";

    $pages = array(
      "Skivor AB" => "index.php",
      "Skivor" => "albums.php",
      "Artister" => "artists.php"
    );

    $active = basename($_SERVER['PHP_SELF']);

    foreach ($pages as $titel => $url) {
      if ($active === $url) {
        echo "<a href=" . $url . " class='active_nav'><h1>" . $titel . "</h1></a>";
      } else {
        echo "<a href=" . $url . "><h1>" . $titel . "</h1></a>";
      }
    }
    ?>
  </nav>