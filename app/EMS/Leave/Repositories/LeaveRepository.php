<?php


namespace App\EMS\Leave\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Leave\Exceptions\LeaveException;
use App\EMS\Leave\Leave;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Mockery\Matcher\Any;

class LeaveRepository extends BaseRepository implements LeaveRepositoryInterface
{
    /**
     * LeaveRepository constructor.
     *
     * @param Leave $leave
     */
    public function __construct(Leave $leave)
    {
        $this->model = $leave;
    }

    /**
     * @param array $data
     *
     * @return Leave
     * @throws LeaveException
     */
    public function createLeave(array $data) : Leave
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new LeaveException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Leave
     * @throws LeaveException
     */
    public function findLeaveById(int $id)
    {
        try {
            return $this->find($id);
        } catch (ModelNotFoundException $e) {
            throw new LeaveException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws LeaveException
     */
    public function updateLeave(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new LeaveException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteLeave() : bool
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
    public function listLeaves($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function listEmployeeLeaves(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'):Collection
    {
        return $this->where($query, $columns, $orderBy, $sortBy);
    }
}
