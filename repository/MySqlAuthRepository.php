<?php
namespace repository;
use PDO;

class MySqlAuthRepository{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists() {
        $query = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                username TEXT,
                password TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $this->db->exec($query);
    }

    public function register(array $values): void {
        $values = (object) $values;
        $query = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
        $sth = $this->db->prepare($query);
        $hashed_password = password_hash($values->password, PASSWORD_DEFAULT);
        $sth->execute(['email' => $values->email, 'username' => $values->username, 'password' => $hashed_password]);
        $values = (array) $values;
        session_start();
        $query = "SELECT users.id FROM users WHERE users.email = :email";
        $sth = $this->db->prepare($query);
        $sth->execute(['email' => $values["email"]]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = [
            'id' => $result['id'],
            'email' => $values["email"],
            'username' => $values["username"]
        ];
    }

    public function login(array $values) {
        $email = $values['email'];
        $query = "SELECT * FROM users WHERE users.email = :email";
        $sth = $this->db->prepare($query);
        $sth->execute(['email' => $email]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($values["password"], $result["password"])){
            return $result;
        }else{
            return false;
        }
    }

    public function logout() {
        session_start();
        if (isset($_SESSION['jwt_token'])) {
            setcookie('token', '', time() - 3600, '/');
            unset($_SESSION['jwt_token']);
        }
        unset($_SESSION['user']);
    }
}