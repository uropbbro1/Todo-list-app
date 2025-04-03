<?php
namespace services;

use repository\MySqlToDoRepository;

class ToDoService{
    private $toDoRepository;

    public function __construct(MySqlToDoRepository $repository) {
        $this->toDoRepository = $repository;
    }

    public function getToDosById(int $id){
        return $this->toDoRepository->findBy($id);
    }

    public function createToDoItem(array $item){
        return $this->toDoRepository->create($item);
    }

    public function updateToDoItem(array $item){
        return $this->toDoRepository->update($item);
    }

    public function deleteToDoItem(int|string $id, int|string $user_id) {
        return $this->toDoRepository->delete($id, $user_id);
    }

    public function sortByStatus(int|string $id, string $sort_type){
        return $this->toDoRepository->sortByStatus($id, $sort_type);
    }

    public function sortByDate(int|string $id, string $sort_type){
        return $this->toDoRepository->sortByDate($id, $sort_type);
    }
}