<?php

require_once "modules/connector.php";

function getData($sql): array
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $res = $pdo->query($sql)->fetchAll();
  // $res = $stmt->fetchAll();
  return $res;
}

function getMonthName($monthNumber): string
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

function getLatestAlbumSongs(): void
{
  $sql = "SELECT * FROM start_songs";
  $songs = getData($sql);
  foreach ($songs as $song) {
    echo "<tr><td>" . $song["name"] . "</td>" . "<td>" . $song["duration"] . "</td>";
  }
}
