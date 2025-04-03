<?php
namespace repository;
use PDO;

class MySqlUsersRepository{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findById(int|string $id): array {
        $query= "SELECT * FROM users WHERE users.id = :id";
        $sth = $this->db->prepare($query);
        $sth->execute(['id' => $id]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $result;
        return $result;
    }

    public function update(int|string $id, array $values): void {
        $query = "UPDATE users SET users.email = :email, users.username = :username WHERE users.id = :id";
        $sth = $this->db->prepare($query);
        $sth->execute(['email' => $values["email"], 'username' => $values["username"], 'id' => $id]);
        session_start();
        $_SESSION['user'] = [
            'id' => $id,
            'email' => $values["email"],
            'username' => $values["username"]
        ];
    }

}