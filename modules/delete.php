<?php

$safeGet = sanitize($_GET);

$sql = "SELECT name from " . $safeGet["item"] . " WHERE id = " . $safeGet["id"];

$name = getData($sql)[0]["name"];

if ($_POST) {
  $safePost = sanitize($_POST);
  $goTo = "location:" . $safeGet["item"] . ".php";
  if ($safeGet["item"] == "songs") {
    $goTo = "location:change.php?action=modify&item=albums&id=" . $safeGet["album"];
  }
  deleteRow($safePost, $safeGet);
  header($goTo);
}

?>

<div class="confirm">
  <h1>Är du säker på att du vill ta bort <?php echo $name; ?></h1>
  <form action="" method="post">
    <input type="submit" name="answer" value="Ja" class="remAns">
    <input type="submit" name="answer" value="Nej" class="remAns">
  </form>
</div>