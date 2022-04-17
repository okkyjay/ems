<?php


namespace App\EMS\Todo\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Todo\Exceptions\TodoException;
use App\EMS\Todo\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{
    /**
     * TodoRepository constructor.
     *
     * @param Todo $todo
     */
    public function __construct(Todo $todo)
    {
        parent::__construct($todo);
        $this->model = $todo;
    }

    /**
     * @param array $data
     *
     * @return Todo
     * @throws TodoException
     */
    public function createTodo(array $data) : Todo
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new TodoException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Todo
     * @throws TodoException
     */
    public function findTodoById(int $id) : Todo
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new TodoException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws TodoException
     */
    public function updateTodo(array $data) : bool
    {
        return $this->update($data);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteTodo() : bool
    {
        try {
            return $this->delete();
        } catch (TodoException $exception){}
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listTodos($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function listEmployeeTodos(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'):Collection
    {
        return $this->where($query, $columns, $orderBy, $sortBy);
    }
}
