<?php
namespace controllers;

use services\AuthService;
use DTO\Validator;
use controllers\JwtHandler;
use controllers\jsonResponseController;

class AuthController{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(){
        $item = [
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
        ];
        $rules = [
            'password' => ['required'],
            'email' => ['required', 'email'],
        ];

        $errors = Validator::validate($item, $rules);

        if (!empty($errors)) {
            //new jsonResponseController()->jsonResponse(['error' => 'Некорректные данные'], 400);
            return include __DIR__ . '/../views/main.php';
        } else {
            $user = $this->authService->login($item);

            if ($user) {
                session_start();
                $jwt = JwtHandler::generateToken($user["id"]);
                $_SESSION['jwt_token'] = $jwt;
                $_SESSION['user'] = $user;
                $this->authService->login($item);
                //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
                header("Location: /profile");
                return include __DIR__ . '/../views/profile.php';
            } else {
                new jsonResponseController()->jsonResponse(['error' => 'Некорректные данные'], 400);
            }
        }
        
    }

    public function register() {
        $item = [
            'email' => $_POST['email'] ?? null,
            'username' => $_POST['username'] ?? null,
            'password' => $_POST['password'] ?? null,
            'password_confirmation' => $_POST['password_confirmation'] ?? null,
        ];
        $rules = [
            'email' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required', 'min:6'],
            'password_confirmation' => ['required', 'confrims:password'],
        ];

        $errors = Validator::validate($item, $rules);

        if (!empty($errors)) {
            //new jsonResponseController()->jsonResponse(['error' => 'Некорректные данные'], 400);
            return include __DIR__ . '/../views/main.php';
        } else {
            $this->authService->register($item);
            //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
            header("Location: /profile");
            return include __DIR__ . '/../views/profile.php';
        }
    }

    public function logout(): string {
        $this->authService->logout();
        //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
        header("Location: /");
        return include __DIR__ . '/../views/main.php';
    }
}