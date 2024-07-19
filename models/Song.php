<?php

class Song
{
    private $conn;
    private $table_name = "songs";


    public $id;
    public $title;
    public $artist;
    public $genre;
    public $album;
    public $release_date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSongsByUser($id)
    {
        $query = "SELECT s.id, s.title, s.artist, s.genre, s.album, s.release_date
            FROM users u
            JOIN music_category mc ON u.music_category_id = mc.id
            JOIN music_category_songs mcs ON mc.id = mcs.music_category_id
            JOIN songs s ON mcs.song_id = s.id
            WHERE u.id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        return $stmt;
    }

    private function getLoggedInUser()
    {

    }
}