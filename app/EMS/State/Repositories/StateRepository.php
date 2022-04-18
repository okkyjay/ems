<?php


namespace App\EMS\State\Repositories;


use App\EMS\BaseRepository;
use App\EMS\State\Exceptions\StateException;
use App\EMS\State\State;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class StateRepository extends BaseRepository implements StateRepositoryInterface
{
    /**
     * StateRepository constructor.
     *
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->model = $state;
    }

    /**
     * @param array $data
     *
     * @return State
     * @throws StateException
     */
    public function createState(array $data) : State
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new StateException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return State
     * @throws StateException
     */
    public function findStateById(int $id) : State
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new StateException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws StateException
     */
    public function updateState(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new StateException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteState() : bool
    {
        return $this->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listStates($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
