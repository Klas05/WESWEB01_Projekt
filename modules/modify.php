<?php
if ($_GET) {
  ob_start();

  /**
   * Saniterar indata och hämtar rätt rad i databasen samt visar upp rätt format genom att inkludera filen med formatet för antingen album eller artister.
   */
  $safeGet = sanitize($_GET);
  $sql = "SELECT * from " . $safeGet["item"] . " WHERE id = :id";
  $arg = ["id" => $safeGet["id"]];
  $result = getData($sql, $arg)[0];

  if ($safeGet["item"] == "albums") {
    $sql = "SELECT * FROM artist_names";
    $artists = getData($sql);
    include_once("modules/modifyAlbum.php");
  }
  if ($safeGet["item"] == "artists") {
    include_once("modules/modifyArtist.php");
  }


  if ($_POST) {
    /**
     * Saniterar indata och antingen avbryter redigeringen genom att skicka tillbaka användaren till artist eller album sidan eller sparar redigeringen genom att uppdatera det valda albumet eller artistens rad i databasen. Lägger även till låtar hos det redigerandes albumet. Skickar tillsist tillbaka användaren till sidan de kom ifrån ifall de inte lade till en låt i ett album.
     */
    $safePost = sanitize($_POST);

    if ($safePost["answer"] == "Avbryt") {
      header("location:" . $safeGet["item"] . ".php");
    }

    $pdo = connectToDb();

    if ($safePost["answer"] === "Lägg till") {
      addRow($safePost);

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
