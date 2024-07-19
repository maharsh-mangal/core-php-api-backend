<?php
include_once '../../controllers/PlaylistController.php';
include_once '../../includes/auth_functions.php';

validateRequestType('POST');
$payload = isAuthenticated();

if (!$payload) {
    echo json_encode(array("message" => "Unauthorized"));
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$songController = new PlaylistController();
echo $songController->create($payload, $data);