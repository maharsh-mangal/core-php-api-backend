<?php
include_once '../../controllers/UserController.php';

validateRequestType('POST');
$data = json_decode(file_get_contents("php://input"), true);

$userController = new UserController();
echo $userController->register($data);
?>
