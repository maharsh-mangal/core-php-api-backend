<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $full_name;
    public $email;
    public $password;
    public $music_category_id;
    public $subscription_expiry;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " SET
                    full_name=:full_name, email=:email, password=:password, music_category_id=:music_category_id, subscription_expiry=:subscription_expiry";

        $stmt = $this->conn->prepare($query);

        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->music_category_id = htmlspecialchars(strip_tags($this->music_category_id));
        $this->subscription_expiry = htmlspecialchars(strip_tags($this->subscription_expiry));

        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":music_category_id", $this->music_category_id);
        $stmt->bindParam(":subscription_expiry", $this->subscription_expiry);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function login() {
        $query = "SELECT id, full_name, password, music_category_id, subscription_expiry FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":email", $this->email);

        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->full_name = $row['full_name'];
            $this->password = $row['password'];
            $this->music_category_id = $row['music_category_id'];
            $this->subscription_expiry = $row['subscription_expiry'];

            return true;
        }

        return false;
    }

    public function verifyPassword($inputPassword) {
        return password_verify($inputPassword, $this->password);
    }

    public function generateToken() {
        $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload = base64_encode(json_encode([
            'id' => $this->id,
            'email' => $this->email,
            'exp' => time() + (60 * 60) // Token valid for 1 hour
        ]));
        $signature = base64_encode(hash_hmac('sha256', "$header.$payload", 'your_secret_key', true));

        return "$header.$payload.$signature";
    }

    public function validateToken($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;

        $signature = base64_decode($signature);


        $expectedSignature = hash_hmac('sha256', "$header.$payload", 'your_secret_key', true);

        $payload = base64_decode($payload);
        $header = base64_decode($header);
        if ($signature !== $expectedSignature) {
            return false;
        }


        $payload = json_decode($payload, true);
        if ($payload['exp'] < time()) {
            return false;
        }

        return $payload;
    }

    public function getById($id)
    {
        $query = "SELECT id, full_name, email, music_category_id, subscription_expiry FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->full_name = $row['full_name'];
            $this->email = $row['email'];
            $this->music_category_id = $row['music_category_id'];
            $this->subscription_expiry = $row['subscription_expiry'];

            return true;
        }

        return false;
    }
}
?>
