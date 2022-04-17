<?php


namespace App\EMS;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Paginate arrays
     *
     * @param array $data
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginateArrayResults(array $data, int $perPage = 50, $page = 1)
    {
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_values(array_slice($data, $offset, $perPage, true)),
            count($data),
            $perPage,
            $page,
            [
                'path' => app('request')->url(),
                'query' => app('request')->query()
            ]
        );
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @param array $query
     * @return mixed
     */
    public function where(array $query, $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->where($query)->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data) : bool
    {
        return $this->model->update($data);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete() : bool
    {
        return $this->model->delete();
    }
}
