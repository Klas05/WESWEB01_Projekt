<?php include(__DIR__ . "/../modules/navbar.php"); ?>

<?php

if ($_GET) {
  require_once __DIR__ . "/../modules/connector.php";

  $pdo = connectToDb();

  $sql = "SELECT name from " . $_GET["item"] . " WHERE id = " . $_GET["id"];

  $res = getData($sql)[0];
}

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
  if ($_POST["answer"] == "Ja") {
    $sql = "DELETE FROM " . $_GET["item"] . " WHERE id = " . $_GET["id"];
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("location:" . $_GET["item"] . ".php");
  } else {
    header("location:" . $_GET["item"] . ".php");
  }
}

?>


<?php include(__DIR__ . "/../modules/footer.php"); ?>