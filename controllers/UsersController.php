<?php
namespace controllers;

use services\UsersService;
use DTO\Validator;
use controllers\jsonResponseController;

class UsersController{
    private UsersService $userService;

    public function __construct(UsersService $userService){
        $this->userService = $userService;
    }

    public function index() {
        return include __DIR__ . '/../views/main.php';
    }

    public function getUser(){
        session_start();
        $this->userService->getUser($_SESSION['user']['id']);
        //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
        return include __DIR__ . '/../views/profile.php';
    }

    public function updateUser() {
        $item = [
            'id' => $_POST['id'] ?? null,
            'email' => $_POST['email'] ?? null,
            'username' => $_POST['username'] ?? null,
        ];
        
        $rules = [
            'email' => ['required'],
            'username' => ['required'],
        ];

        $errors = Validator::validate($item, $rules);

        if (!empty($errors)) {
            //new jsonResponseController()->jsonResponse(['error' => 'Некорректные данные'], 400);
            return include __DIR__ . '/../views/profile.php';
        } else {
            $this->userService->updateUser($item["id"], $item);
            //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
            header("Location: /profile");
            return include __DIR__ . '/../views/profile.php';
        }        
    }
}