<?php
ob_start();

$sql = "SELECT * from " . $_GET["item"] . " WHERE id = " . $_GET["id"];
$result = getData($sql)[0];

if ($_GET["item"] == "albums") {
  $sql = "SELECT * FROM artist_names";
  $artists = getData($sql);
  include("modules/modifyAlbum.php");
}
if ($_GET["item"] == "artists") {
  include("modules/modifyArtist.php");
}


?>
<?php

if ($_POST) {
  if ($_POST["answer"] == "Avbryt") {
    header("location:" . $_GET["item"] . ".php");
  }

  $pdo = connectToDb();

  if ($_POST["answer"] === "Lägg till") {
    $name = $_POST["name"];
    $duration = "00:" . $_POST["duration"];
    $release_year = $_POST["release_year"];
    $album_id = $result["id"];
    $artist_id = $result["artist_id"];

    $sql = "INSERT INTO songs (name, duration, release_year, album_id, artist_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $duration, $release_year, $album_id, $artist_id]);

    header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
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
