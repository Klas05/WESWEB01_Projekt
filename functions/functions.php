<?php

require_once __DIR__ . "/../modules/connector.php";

function getData($sql): array
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $res = $pdo->query($sql)->fetchAll();
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

function getSongs($id, $item = "albums"): array
{
  $foreignKey = substr_replace($item, "", -1) . "_id";
  $sql = "SELECT id, name, duration, release_year FROM songs WHERE " . $foreignKey .  " = " . $id;
  return getData($sql);
}
