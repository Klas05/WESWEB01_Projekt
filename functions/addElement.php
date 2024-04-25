<?php

require_once "../modules/connector.php";

$pdo = connectToDb();

$safePost = array_map('strip_tags', $_POST);

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

header("location:../" . $item . ".php");
