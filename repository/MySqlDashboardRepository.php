<?php
namespace repository;
use PDO;

class MySqlDashboardRepository{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findById(int|string $id) {
        $query_in_progress = "SELECT * FROM todos WHERE todos.user_id = :id AND todos.status = :status";
        $sth = $this->db->prepare($query_in_progress);
        $sth->execute(['id' => $id, 'status' => 'В работе']);
        $result_in_progress = $sth->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['user'] = [
            'id' => $id
        ];
        $_SESSION['in_progress_tasks']  = $result_in_progress;

        $query_complete = "SELECT * FROM todos WHERE todos.user_id = :id AND todos.status = :status";
        $sth = $this->db->prepare($query_complete);
        $sth->execute(['id' => $id, 'status' => 'Завершено']);
        $result_complete = $sth->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['complete_tasks']  = $result_complete;

        $query_deadline = "SELECT * FROM todos WHERE todos.user_id = :id AND todos.status = :status";
        $sth = $this->db->prepare($query_deadline);
        $sth->execute(['id' => $id, 'status' => 'Дедлайн']);
        $result_deadline = $sth->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['deadline_tasks']  = $result_deadline;
    }
}