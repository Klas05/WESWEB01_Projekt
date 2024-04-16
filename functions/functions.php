<?php

require_once "modules/connector.php";

function getData($sql): array
{
  try {
    $pdo = connectToDb();
  } catch (PDOException $e) {
    die("Fel: " . $e->getMessage());
  }
  $stmt = $pdo->query($sql);
  $res = $stmt->fetchAll();
  return $res;
}
