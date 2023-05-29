<?php
require "dbconnection.php";
require 'error.php';
$dbcon = createDbConnection();

$body = file_get_contents("php://input");
$data = json_decode($body);

try {
    $dbcon->beginTransaction();

    $playlistId = strip_tags($data?->playlistId);

    $statement = $dbcon->prepare("DELETE playlists, playlist_track FROM playlists INNER JOIN playlist_track ON playlists.PlaylistId = playlist_track.PlaylistId WHERE playlist_track.PlaylistId=?");
    $statement->execute(array($playlistId));
    $dbcon->commit();
}

catch (PDOException $pdoex) {
    $dbcon->rollBack();
    returnError($pdoex);
}