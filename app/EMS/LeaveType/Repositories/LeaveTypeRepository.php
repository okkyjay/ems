<?php


namespace App\EMS\LeaveType\Repositories;


use App\EMS\BaseRepository;
use App\EMS\LeaveType\Exceptions\LeaveTypeException;
use App\EMS\LeaveType\LeaveType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class LeaveTypeRepository extends BaseRepository implements LeaveTypeRepositoryInterface
{
    /**
     * LeaveTypeRepository constructor.
     *
     * @param LeaveType $leaveType
     */
    public function __construct(LeaveType $leaveType)
    {
        $this->model = $leaveType;
    }

    /**
     * @param array $data
     *
     * @return LeaveType
     * @throws LeaveTypeException
     */
    public function createLeaveType(array $data) : LeaveType
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new LeaveTypeException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return LeaveType
     * @throws LeaveTypeException
     */
    public function findLeaveTypeById(int $id) : LeaveType
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new LeaveTypeException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws LeaveTypeException
     */
    public function updateLeaveType(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new LeaveTypeException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteLeaveType() : bool
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
    public function listLeaveTypes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
