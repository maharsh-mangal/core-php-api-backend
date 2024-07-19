<?php

class Playlist
{

    private $conn;
    private $table_name = "playlists";

    public $id;
    public $name;
    public $user_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($name, $user_id)
    {
        $query = "INSERT INTO
                        playlists (user_id, name)
                  VALUES
                        (:user_id, :name)";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":name", $name);

        $stmt->execute();
        return $stmt;
    }

    public function addSongs($id, array $songs)
    {
        $query = "INSERT INTO
                        playlist_songs (playlist_id, song_id)
                  VALUES
                        (:playlist_id, :song_id)";

        $stmt = $this->conn->prepare($query);

        foreach ($songs as $song) {
            $stmt->bindParam(":playlist_id", $id);
            $stmt->bindParam(":song_id", $song);
            $stmt->execute();
        }
        return $stmt;
    }
}