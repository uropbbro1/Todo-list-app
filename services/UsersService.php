<?php
namespace services;

use repository\MySqlUsersRepository;

class UsersService{
    private $usersRepository;

    public function __construct(MySqlUsersRepository $repository) {
        $this->usersRepository = $repository;
    }

    public function getUser(int|string $id){
        return $this->usersRepository->findById($id);
    }

    public function updateUser(int|string $id, array $item){
        return $this->usersRepository->update($id, $item);
    }
}