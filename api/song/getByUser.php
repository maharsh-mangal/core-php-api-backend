<?php

include_once '../../controllers/SongController.php';
include_once '../../includes/auth_functions.php';

validateRequestType('GET');
$payload = isAuthenticated();

if (!$payload) {
    echo json_encode(array("message" => "Unauthorized"));
    exit();
}

$songController = new SongController();
echo $songController->getByUser($payload);