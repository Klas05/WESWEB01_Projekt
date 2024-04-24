<?php

include("modules/navbar.php");

require_once "functions/functions.php";

$sql = "SELECT * FROM start";

$album = getData($sql)[0];

?>

<div class="wrapper">
  <img src="<?php echo $album["img"]; ?>" alt="">
  <div class="info">
    <h2><?php echo $album["artist"] . " - ";
        echo $album["name"]; ?></h2>
    <h3><?php echo "Släpptes " . $album["YEAR"] . " den " . $album["DAY"] . " " . getMonthName($album["MONTH"]); ?></h3>
    <h4>Låtar:</h4>
    <table>
      <tr>
        <th>Låt namn</th>
        <th>Längd</th>
      </tr>
      <?php
      $songs = getSongs($album["id"]);

      foreach ($songs as $song) {
        echo "<tr><td>" . $song["name"] . "</td>" . "<td>" . $song["duration"] . "</td>";
      }
      ?>
    </table>
  </div>
</div>

<?php include("modules/footer.php"); ?>