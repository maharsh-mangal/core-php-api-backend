<?php
include_once '../../config/Database.php';
include_once '../../models/Song.php';

class SongController
{
    private $db;
    private $song;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->song = new Song($this->db);
        $this->user = new User($this->db);
    }

    public function getByUser($payload)
    {
        $this->user->id = $payload['id'];

        $result = $this->song->getSongsByUser($this->user->id);

        if ($result->rowCount() > 0) {
            $songs_arr = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $song_item = array(
                    "id" => $id,
                    "title" => $title,
                    "artist" => $artist,
                    "genre" => $genre,
                    "album" => $album,
                    "release_date" => $release_date
                );
                $songs_arr[] = $song_item;
            }
            return json_encode($songs_arr);
        } else {
            return json_encode(array("message" => "No songs found."));
        }
    }

}