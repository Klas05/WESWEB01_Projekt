<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skivor AB</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <nav>
    <?php

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