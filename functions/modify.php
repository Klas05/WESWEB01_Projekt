<?php

$sql = "SELECT * from " . $_GET["item"] . " WHERE id = " . $_GET["id"];
$res = getData($sql)[0];

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

  if ($_POST["answer"] == "Lägg till") {
    $sql = "INSERT INTO songs (name, duration, release_year, album_id, artist_id) VALUES ('" . $_POST["name"] . "', '00:" . $_POST["duration"] . "', " . $_POST["release_year"] . ", " . $res["id"] . ", " . $res["artist_id"] . ")";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    // print_r($sql);

    // die();
  }


  $update = "";

  foreach ($_POST as $key => $value) {
    if ($key !== "answer") {
      $update = $update . $key . " = '" . $value . "', ";
    }
  }

  $update = substr_replace($update, " ", -2);

  $sql = "UPDATE " . $_GET['item'] . " SET " . $update . "WHERE id = " . $res["id"] . ";";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  header("location:" . $_GET["item"] . ".php");
}
