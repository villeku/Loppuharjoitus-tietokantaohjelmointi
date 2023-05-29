<?php
require "dbconnection.php";
require 'error.php';
$dbcon = createDbConnection();

try {
    $body = file_get_contents("php://input");
    $data = json_decode($body);

    $sql = "SELECT tracks.Name, tracks.Composer FROM tracks INNER JOIN playlist_track ON tracks.TrackId = playlist_track.TrackId INNER JOIN playlists ON playlist_track.PlaylistId = playlists.PlaylistId WHERE playlists.PlaylistId=?";

    $playlist_id = strip_tags($data->playlist_id);

    $statement = $dbcon->prepare($sql);
    $statement->execute(array($playlist_id));

    $echo = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($echo as $e) {
        echo "<h3>".$e["Name"]."</h3>"."<br>".$e["Composer"]."<br>";
    }
}

catch (PDOException $pdoex) {
    returnError($pdoex);
}