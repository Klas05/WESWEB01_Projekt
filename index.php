<?php

include("modules/navbar.php");

require_once "functions/functions.php";

$sql = "SELECT * FROM start";

$album = getData($sql);

?>

<div class="wrapper">
  <img src="<?php echo $album[0]["img"]; ?>" alt="">
  <div class="info">
    <h2><?php echo $album[0]["artist"] . " - ";
        echo $album[0]["name"]; ?></h2>
    <h3><?php echo "Släpptes " . $album[0]["YEAR"] . " den " . $album[0]["DAY"] . " " . getMonthName($album[0]["MONTH"]); ?></h3>
    <h4>Låtar:</h4>
    <table>
      <tr>
        <th>Låt namn</th>
        <th>Längd</th>
      </tr>
      <?php getLatestAlbumSongs(); ?>
    </table>
  </div>
</div>

<?php

include("modules/footer.php");

?>