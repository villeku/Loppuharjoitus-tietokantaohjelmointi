<?php
require "dbconnection.php";
require 'error.php';
$dbcon = createDbConnection();

try {
    $body = file_get_contents("php://input");
    $data = json_decode($body);

    $artist_id = strip_tags($data?->artist_id);

    $statement = $dbcon->prepare("SELECT tracks.Name FROM artists INNER JOIN albums ON artists.ArtistId = albums.ArtistId INNER JOIN tracks ON albums.AlbumId = tracks.AlbumId WHERE artists.ArtistId=?");
    $statement->execute(array($artist_id));

    $echo = $statement->fetchAll(PDO::FETCH_ASSOC);
    header('Content-type: application/json');

    foreach ($echo as $e) {
        echo $e["Name"]."<br>";
    }

    $echo = json_encode($statement);
    return($echo);
}

catch (PDOException $pdoex) {
    returnError($pdoex);
}