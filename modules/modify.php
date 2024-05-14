<?php
if ($_GET) {
  ob_start();

  $safeGet = sanitize($_GET);
  $sql = "SELECT * from " . $safeGet["item"] . " WHERE id = " . $safeGet["id"];
  $result = getData($sql)[0];

  if ($safeGet["item"] == "albums") {
    $sql = "SELECT * FROM artist_names";
    $artists = getData($sql);
    include_once("modules/modifyAlbum.php");
  }
  if ($safeGet["item"] == "artists") {
    include_once("modules/modifyArtist.php");
  }


  if ($_POST) {
    $safePost = sanitize($_POST);

    if ($safePost["answer"] == "Avbryt") {
      header("location:" . $safeGet["item"] . ".php");
    }

    $pdo = connectToDb();

    if ($safePost["answer"] === "Lägg till") {
      addRow($_safePost);

      header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    }

    $updateFields = [];
    $updateValues = [];

    foreach ($safePost as $key => $value) {
      if ($key !== "answer") {
        $updateFields[] = $key . " = ?";
        $updateValues[] = $value;
      }
    }

    $updateFieldsString = implode(", ", $updateFields);

    $sql = "UPDATE " . $safeGet['item'] . " SET " . $updateFieldsString . " WHERE id = ?";
    $updateValues[] = $result["id"];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($updateValues);

    header("location:" . $safeGet["item"] . ".php");
  }

  ob_flush();
}
