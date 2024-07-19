<?php
include_once '../../config/database.php';
include_once '../../models/User.php';

class UserController {
    private $db;
    private $user;
    private $errors = [];

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    public function register($data) {
        if(!$this->validateRegisterUserData($data)) {
            http_response_code(422);
            return json_encode(array(
                "errors" => $this->errors,
                "message" => "Unable to register the user."
            ));
        }

        $this->user->full_name = $data['full_name'];
        $this->user->email = $data['email'];
        $this->user->password = $data['password'];
        $this->user->music_category_id = $data['music_category'];
        $this->user->subscription_expiry = date('Y-m-d', strtotime('+6 months'));

        if($this->user->register()) {
            return json_encode(array("message" => "User registered successfully."));
        } else {
            return json_encode(array("message" => "Unable to register the user."));
        }
    }

    public function login($data) {
        if(!$this->validateLoginData($data)) {
            http_response_code(422);
            return json_encode(array(
                "errors" => $this->errors,
                "message" => "Unable to login."
            ));
        }
        $this->user->email = $data['email'];
        $isPasswordCorrect = $this->user->verifyPassword($data['password']);
        if (!$isPasswordCorrect) {
            return json_encode(array("message" => "Email not found! Oh my god! Its happening! Everybody stay calm!"));
        }
        if (!$isPasswordCorrect) {
            return json_encode(array("message" => "Wrong Password! Identity Theft is not a joke Jim! Millions of families suffer every year!"));
        }

        if($this->user->login() && $isPasswordCorrect) {
            $token = $this->user->generateToken();
            return json_encode(array(
                "message" => "Login successful.",
                "token" => $token
            ));
        } else {
            return json_encode(array("message" => "Invalid email or password."));
        }
    }

    private function validateRegisterUserData($data) {
        if (!isset($data['full_name'])) {
            $this->errors[] = "Full name is required.";
        }
        if (!isset($data['email'])) {
            $this->errors[] = "Email is required.";
        }
        if (!isset($data['password'])) {
            $this->errors[] = "Password is required.";
        }
        if (!isset($data['music_category'])) {
            $this->errors[] = "Music category is required.";
        }
        return count($this->errors) === 0;
    }

    private function validateLoginData($data) {
        if (!isset($data['email'])) {
            $this->errors[] = "Email is required.";
        }
        if (!isset($data['password'])) {
            $this->errors[] = "Password is required.";
        }
        return count($this->errors) === 0;
    }
}
?>
