<?php

require_once "../modules/connector.php";

$pdo = connectToDb();

$safePost = array_map('strip_tags', $_POST);

$sql = "INSERT INTO albums (artist_id, name, rating, release_date) VALUES (:artist, :album, :rating, :release);";

print_r($safePost);

$stmt = $pdo->prepare($sql);
$stmt->execute($safePost);

header("location:../albums.php");
