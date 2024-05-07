<?php

require_once __DIR__ . "/../modules/connector.php";

/**
 * Filtrerar användar input i GET- och POST förfrågningar
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
function getData(string $sql): array
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $res = $pdo->query($sql)->fetchAll();
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
function deleteRow(array $post, array $get): void
{
  $safePost = sanitize($post);
  $safeGet = sanitize($get);
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
 * Lägg till rad i databasen
 * 
 * 
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
  print_r($safePost);
  $stmt->execute($safePost);
}

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

function getSongs(int $id, string $item = "albums"): array
{
  $foreignKey = substr_replace($item, "", -1) . "_id";
  $sql = "SELECT id, name, duration, release_year FROM songs WHERE " . $foreignKey .  " = " . $id;
  return getData($sql);
}
