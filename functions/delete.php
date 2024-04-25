<?php

require_once __DIR__ . "/../modules/connector.php";

$sql = "SELECT name from " . $_GET["item"] . " WHERE id = " . $_GET["id"];

$res = getData($sql)[0];


?>

<div class="confirm">
  <h1>Är du säker på att du vill ta bort <?php echo $res["name"]; ?></h1>
  <form action="" method="post">
    <input type="submit" name="answer" value="Ja" class="remAns">
    <input type="submit" name="answer" value="Nej" class="remAns">
  </form>
</div>

<?php
if ($_POST) {
  $location = "location:" . $_GET["item"] . ".php";
  if ($_GET["item"] == "songs") {
    $location = "location:change.php?action=modify&item=albums&id=" . $_GET["album"];
  }
  if ($_POST["answer"] == "Ja") {
    $pdo = connectToDb();
    if ($_GET["item"] == "artists") {
      $sqls = array("DELETE FROM songs WHERE artist_id = " . $_GET["id"] . ";", "DELETE FROM albums WHERE artist_id = " . $_GET["id"] . ";");
      foreach ($sqls as $sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
      }
    }
    $sql = "DELETE FROM " . $_GET["item"] . " WHERE id = " . $_GET["id"];
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header($location);
  } else {
    header($location);
  }
}

?>