<?php
ob_start();

$sql = "SELECT * from " . $_GET["item"] . " WHERE id = " . $_GET["id"];
$result = getData($sql)[0];

if ($_GET["item"] == "albums") {
  $sql = "SELECT * FROM artist_names";
  $artists = getData($sql);
  include_once("modules/modifyAlbum.php");
}
if ($_GET["item"] == "artists") {
  include_once("modules/modifyArtist.php");
}


?>
<?php

if ($_POST) {
  if ($_POST["answer"] == "Avbryt") {
    header("location:" . $_GET["item"] . ".php");
  }

  $pdo = connectToDb();

  if ($_POST["answer"] === "Lägg till") {
    addRow($_POST);

    header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    print_r($_POST);
  }

  $updateFields = [];
  $updateValues = [];

  foreach ($_POST as $key => $value) {
    if ($key !== "answer") {
      $updateFields[] = $key . " = ?";
      $updateValues[] = $value;
    }
  }

  $updateFieldsString = implode(", ", $updateFields);

  $sql = "UPDATE " . $_GET['item'] . " SET " . $updateFieldsString . " WHERE id = ?";
  $updateValues[] = $result["id"];

  $stmt = $pdo->prepare($sql);
  $stmt->execute($updateValues);

  header("location:" . $_GET["item"] . ".php");
}

ob_flush();
