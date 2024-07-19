<?php
include_once '../../models/Playlist.php';
include_once '../../models/User.php';
include_once '../../models/Song.php';
class PlaylistController
{
    private $db;
    private $playlist;
    private $user;
    private $errors = [];

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->playlist = new Playlist($this->db);
        $this->user = new User($this->db);
    }

    public function create($payload, $data)
    {
        if (!isset($data['name'])) {
            http_response_code(422);
            return json_encode(array("message" => "Playlist name is required."));
        }

        $this->user->id = $payload['id'];
        $this->playlist->name = $data['name'];
        $this->playlist->user_id = $this->user->id;

        if ($this->playlist->create(
            $this->playlist->name,
            $this->playlist->user_id
        )) {
            return json_encode(array("message" => "Playlist created successfully."));
        } else {
            return json_encode(array("message" => "Unable to create the playlist."));
        }
    }

    public function addSongs($payload, $data)
    {
        if (!$this->validateSongData($data)) {
            http_response_code(422);
            return json_encode(
                array(
                    "errors" => $this->errors,
                    "message" => "Unable to add songs to the playlist."
                )
            );
        }
        $this->user->id = $payload['id'];
        $this->playlist->id = $data['playlist_id'];
        $this->playlist->user_id = $this->user->id;
        $this->playlist->songs = $data['songs'];

        if ($this->playlist->addSongs(
            $this->playlist->id,
            $this->playlist->songs
        )) {
            return json_encode(array("message" => "Songs added to the playlist successfully."));
        } else {
            return json_encode(array("message" => "Unable to add songs to the playlist."));
        }
    }

    private function validateSongData($data)
    {
        if (!isset($data['playlist_id'])) {
            $this->errors[] = "Playlist ID is required.";
        }

        if (!isset($data['songs'])) {
            $this->errors[] = "Songs are required.";
        }

        if (gettype($data['songs']) !== 'array') {
            $this->errors[] = "Songs must be an array.";
        }

        return count($this->errors) === 0;
    }
}