<?php
namespace services;

use repository\MySqlAuthRepository;

class AuthService{
    private $authRepository;

    public function __construct(MySqlAuthRepository $repository) {
        $this->authRepository = $repository;
    }

    public function login(array $item){
        return $this->authRepository->login($item);
    }

    public function register(array $item){
        return $this->authRepository->register($item);
    }

    public function logout() {
        return $this->authRepository->logout();
    }
}