<?php


namespace App\EMS\Todo\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Todo\Todo;
use Illuminate\Support\Collection;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
    public function createTodo(array $data): Todo;

    public function findTodoById(int $id) : Todo;

    public function updateTodo(array $data) : bool;

    public function deleteTodo() : bool;

    public function listTodos($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    public function listEmployeeTodos(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
