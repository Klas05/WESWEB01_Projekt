<?php

$sql = "SELECT name from " . $_GET["item"] . " WHERE id = " . $_GET["id"];

$name = getData($sql)[0]["name"];

if ($_POST) {
  $goTo = "location:" . $_GET["item"] . ".php";
  if ($get["item"] == "songs") {
    $goTo = "location:change.php?action=modify&item=albums&id=" . $get["album"];
  }
  if ($_POST["answer"] == "Ja") {
    deleteRow($_POST, $_GET);
  }
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