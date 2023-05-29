<?php
require "dbconnection.php";
require 'error.php';
$dbcon = createDbConnection();

try {
    $body = file_get_contents("php://input");
    $data = json_decode($body);

    $new_artist = strip_tags($data?->new_artist);

    $statement = $dbcon->prepare("INSERT INTO artists (ArtistId, Name) VALUES (Default, ?)");
    $statement->execute(array($new_artist));

    $last_id = $dbcon->lastInsertId();

    $new_album = strip_tags($data?->new_album);
    $statement = $dbcon->prepare("INSERT INTO albums (AlbumId, Title, ArtistId) VALUES (Default, ?, ?)");
    $statement->execute(array($new_album, $last_id));

    
}

catch (PDOException $pdoex) {
    returnError($pdoex);
}