<?php

require_once __DIR__ . "/../modules/connector.php";

/**
 * Undocumented function
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

function deleteRow(array $post, array $get): void
{
  $safePost = array_map('strip_tags', $post);
  if ($safePost["answer"] == "Ja") {
    try {
      $pdo = connectToDb();
    } catch (PDOException $e) {
      die("Fel: " . $e->getMessage());
    }
    if ($get["item"] == "artists") {
      $sqls = array("DELETE FROM songs WHERE artist_id = " . $get["id"] . ";", "DELETE FROM albums WHERE artist_id = " . $get["id"] . ";");
      foreach ($sqls as $sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
      }
    }
    $sql = "DELETE FROM " . $get["item"] . " WHERE id = " . $get["id"];
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
  }
}


function addRow(array $post): void
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $safePost = array_map('strip_tags', $post);

  $item = $safePost["add"];

  unset($safePost["add"]);

  if ($item == "albums") {
    $sql = "INSERT INTO albums (artist_id, name, rating, release_date) VALUES (:artist, :album, :rating, :release);";
  }
  if ($item == "artists") {
    $sql = "INSERT INTO artists (name, genre) VALUES (:name, :genre);";
  }

  $stmt = $pdo->prepare($sql);
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
