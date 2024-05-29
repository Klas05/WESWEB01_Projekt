<?php

/**
 * Konfirmations sida för att radera rad i databasen. Vid "ja" så förbereds rätt sql query till den valda raden och exekverar den därefter. Till sist så skickas användaren tillbaka till den sidan de kom från. Om användaren har ändrat i länken så att felaktig indata hanteras blir användaren skickad till startsidan.
 */

$safeGet = sanitize($_GET);
try {
  $sql = "SELECT name from " . $safeGet["item"] . " WHERE id = :id";
  $arg = ["id" => $safeGet["id"]];
  $name = getData($sql, $arg)[0]["name"];
  if ($_POST) {
    $safePost = sanitize($_POST);
    $goTo = "location:" . $safeGet["item"] . ".php";
    if ($safeGet["item"] == "songs") {
      $goTo = "location:change.php?action=modify&item=albums&id=" . $safeGet["album"];
    }
    deleteRow($safePost, $safeGet);
    header($goTo);
  }
  if ($name == "") {
    echo "<h1>Aja baja, ändra inte i länken tack!</h1>";
    sleep(5);
    header("location:index.php");
  }
} catch (\Throwable $th) {
  echo "<h1>Aja baja, ändra inte i länken tack!</h1>";
  sleep(5);
  header("location:index.php");
}


?>

<div class="confirm">
  <h1>Är du säker på att du vill ta bort <?php echo $name; ?></h1>
  <form action="" method="post">
    <input type="submit" name="answer" value="Ja" class="remAns">
    <input type="submit" name="answer" value="Nej" class="remAns">
  </form>
</div>