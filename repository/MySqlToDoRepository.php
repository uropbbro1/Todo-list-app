<?php
namespace repository;
use PDO;

class MySqlToDoRepository{
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
                username TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                password TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $this->db->exec($query);
        
        $query = "
            CREATE TABLE IF NOT EXISTS `todos` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `status` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $this->db->exec($query);

        $query = "ALTER TABLE `users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        $this->db->exec($query);
        $query = "ALTER TABLE `todos` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        $this->db->exec($query);
    }

    public function findBy(int|string $id) {
        $query= "SELECT * FROM todos WHERE todos.user_id = :user_id";
        $sth = $this->db->prepare($query);
        $sth->execute(['user_id' => $id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['user'] = ["id" => $id];
        $_SESSION['tasks']  = $result;
    }

    public function create(array $values): void {
        $query = "INSERT INTO todos (title, user_id, description, status) VALUES (:title, :user_id, :description, :status)";
        $sth = $this->db->prepare($query);
        $sth->execute(['title' => $values["title"], 'description' => $values["description"], 'status' => $values["status"], 'user_id' => $values["user_id"]]);
        session_start();
        $_SESSION['after_creation'] = true;
        $_SESSION['user'] = ["id" => $values["user_id"]];
    }

    public function update(array $values): void {
        $query = "UPDATE todos SET todos.title = :title, todos.description = :description, todos.status = :status WHERE todos.id = :id";
        $sth = $this->db->prepare($query);
        $sth->execute(['title' => $values["title"], 'description' => $values["description"], 'status' => $values["status"], 'id' => $values["id"]]);
        session_start();
        $_SESSION['user'] = [
            'id' => $values['user_id']
        ];
    }

    public function delete(int|string $id, int|string $user_id) {
        $query = "DELETE FROM todos WHERE todos.id = :id";
        $sth = $this->db->prepare($query);
        $sth->execute(['id' => $id]);
        session_start();
        $_SESSION['user'] = [
            'id' => $user_id
        ];
    }

    public function sortByStatus(int|string $id, string $sort_type){
        switch($sort_type){
            case 'in_progress':
                $type = 'В работе';
                break;
            case 'complete':
                $type = 'Завершено';
                break;
            default:
                $type = "Дедлайн";
        }
        $query= "SELECT * FROM todos WHERE todos.user_id = :user_id AND todos.status = :status";
        $sth = $this->db->prepare($query);
        $sth->execute(['user_id' => $id, 'status' => $type]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['user'] = ["id" => $id];
        $_SESSION['tasks']  = $result;
    }

    public function sortByDate(int|string $id, string $sort_type){
        $sortDirection = ($sort_type === 'newer') ? 'DESC' : 'ASC';
        $query= "SELECT * FROM todos WHERE todos.user_id = :user_id ORDER BY todos.created_at " . $sortDirection . ";";
        $sth = $this->db->prepare($query);
        $sth->execute(['user_id' => $id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['user'] = ["id" => $id];
        $_SESSION['tasks']  = $result;
    }
}