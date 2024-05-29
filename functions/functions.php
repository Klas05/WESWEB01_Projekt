<?php

require_once __DIR__ . "/../modules/connector.php";

/**
 * Filtrerar användar input i GET- och POST förfrågningar.
 *
 * @param array $getOrPost
 * @return array
 */
function sanitize(array $getOrPost): array
{
  return array_map('strip_tags', $getOrPost);
}

/**
 * Hämta data från databasen
 * 
 * Tar in en query som argument och returnerar resultatet i en lista från databasen.
 *
 * @param string $sql
 * @return array
 */
function getData(string $sql, array $args = NULL): array
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $stmt = $pdo->prepare($sql);
  $stmt->execute($args);
  $res = $stmt->fetchAll();
  return $res;
}

/**
 * Raderar en rad i databasen
 * 
 * Tar emot en POST- och GET-förfrågan och kollar om användaren vill radera vald rad.
 * Ifall det är en artist rad tar den även bort album och låtar som tillhör artisten.
 *
 * @param array $post
 * @param array $get
 * @return void
 */
function deleteRow(array $safePost, array $safeGet): void
{
  if ($safePost["answer"] == "Ja") {
    try {
      $pdo = connectToDb();
    } catch (PDOException $e) {
      die("Fel: " . $e->getMessage());
    }
    if ($safeGet["item"] == "artists") {
      $sqls = array("DELETE FROM songs WHERE artist_id = " . $safeGet["id"] . ";", "DELETE FROM albums WHERE artist_id = " . $safeGet["id"] . ";");
      foreach ($sqls as $sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
      }
    }
    $sql = "DELETE FROM " . $safeGet["item"] . " WHERE id = " . $safeGet["id"];
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
  }
}

/**
 * Lägger till rad i databasen. Utifrån indatan som skickas så anpassas sql query:n till rätt tabell i databasen med rätt värden.
 * 
 * @param array $post
 * @return void
 */
function addRow(array $post): void
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $safePost = sanitize($post);

  $item = "songs";
  if (isset($safePost["answer"])) {
    unset($safePost["answer"]);

    $safePost["duration"] = "00:" . $safePost["duration"];
  }
  if (isset($safePost["add"])) {
    $item = $safePost["add"];
    unset($safePost["add"]);
  }

  if ($item == "albums") {
    $sql = "INSERT INTO albums (artist_id, name, rating, release_date) VALUES (:artist, :album, :rating, :release);";
  }
  if ($item == "artists") {
    $sql = "INSERT INTO artists (name, genre) VALUES (:name, :genre);";
  }
  if ($item == "songs") {
    $sql = "INSERT INTO songs (name, duration, release_year, album_id, artist_id) VALUES (:name, :duration, :release_year, :album_id, :artist_id);";
  }

  $stmt = $pdo->prepare($sql);
  $stmt->execute($safePost);
}

/**
 * Hämtar en månads namn utefter siffran dvs månad 1-12.
 *
 * @param integer $monthNumber
 * @return string
 */
function getMonthName(int $monthNumber): string
{
  // Skapa en array med månadernas namn
  $monthNames = array(
    "Januari",
    "Februari",
    "Mars",
    "April",
    "Maj",
    "Juni",
    "Juli",
    "Augusti",
    "September",
    "Oktober",
    "November",
    "December"
  );

  // Kontrollera om angivet månadsvärde är giltigt
  if ($monthNumber >= 1 && $monthNumber <= 12) {
    // Returnera månadens namn från arrayen
    return $monthNames[$monthNumber];
  } else {
    // Om ogiltigt värde, returnera en felmeddelande-sträng
    return "Ogiltigt månadsvärde";
  }
}

/**
 * Hämtar låtarna som finns under inmatat album eller artist från databasen.
 *
 * @param integer $id
 * @param string $item
 * @return array
 */
function getSongs(int $id, string $item = "albums"): array
{
  $foreignKey = rtrim($item, 's') . "_id";
  $sql = "SELECT id, name, duration, release_year FROM songs WHERE " . $foreignKey . " = :id";
  $args = ["id" => $id];
  return getData($sql, $args);
}
