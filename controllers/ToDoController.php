<?php
namespace controllers;

use services\ToDoService;
use DTO\Validator;
use controllers\jsonResponseController;

class ToDoController{
    private ToDoService $toDoService;

    public function __construct(ToDoService $toDoService){
        $this->toDoService = $toDoService;
    }

    public function getToDosById(){
        session_start();
        $this->toDoService->getToDosById($_SESSION['user']['id']);
        //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
        return include __DIR__ . '/../views/todoList.php';
    }

    public function create(): string {
        $item = [
            'user_id' => $_POST['id'] ?? null,
            'title' => $_POST['title'] ?? null,
            'description' => $_POST['description'] ?? null,
            'status' => $_POST['status'] ?? null,
        ];

        $rules = [
            'title' => ['required'],
            'status' => ['required'],
        ];

        $errors = Validator::validate($item, $rules);

        if (!empty($errors)) {
            //new jsonResponseController()->jsonResponse(['error' => 'Некорректные данные'], 400);
            return include __DIR__ . '/../views/todoList.php';
        } else {
            $this->toDoService->createToDoItem($item);
            //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
            header("Location: /todos");
            return include __DIR__ . '/../views/todoList.php';
        }
    }
    
    public function delete(): string {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $this->toDoService->deleteToDoItem($id, $user_id);
        //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
        header("Location: /todos");
        return include __DIR__ . '/../views/todoList.php';
    }

    public function update() {

        $item = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'status' => $_POST['status'],
            'user_id' => $_POST['user_id'],
            'id' => $_POST['id'],
        ];

        $rules = [
            'title' => ['required'],
            'status' => ['required'],
        ];

        $errors = Validator::validate($item, $rules);

        if (!empty($errors)) {
            //new jsonResponseController()->jsonResponse(['error' => 'Некорректные данные'], 400);
            return include __DIR__ . '/../views/todoList.php';
        } else {
            $this->toDoService->updateToDoItem($item);
            //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
            header("Location: /todos");
            return include __DIR__ . '/../views/todoList.php';
        }
    }

    public function sortByStatus() {
        session_start();
        $item = [
            'user_id' => $_SESSION['user']['id'],
            'status' => $_POST["status"]
        ];

        $this->toDoService->sortByStatus($item["user_id"], $item["status"]);
        header("Location: /todos");
        return include __DIR__ . '/../views/todoList.php';
    }

    public function sortByDate() {
        session_start();
        $item = [
            'user_id' => $_SESSION['user']['id'],
            'date' => $_POST["date"]
        ];

        $this->toDoService->sortByDate($item["user_id"], $item["date"]);
        header("Location: /todos");
        return include __DIR__ . '/../views/todoList.php';
    }
}