<?php
include_once '../../models/User.php';
include_once '../../config/Database.php';

function isAuthenticated() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        return false;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $database = new Database();
    $db = $database->connect();
    $user = new User($db);

    $payload = $user->validateToken($token);
    if (!$payload) {
        return false;
    }

    return $payload;
}

function validateRequestType($expected)
{
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method !== $expected) {
        http_response_code(405);
        echo json_encode(array("message" => "The $method method is not allowed for this route. Suggested method: $expected."));
        exit();
    }

}