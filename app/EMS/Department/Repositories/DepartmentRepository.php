<?php


namespace App\EMS\Department\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Department\Exceptions\DepartmentException;
use App\EMS\Department\Department;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    /**
     * DepartmentRepository constructor.
     *
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        $this->model = $department;
    }

    /**
     * @param array $data
     *
     * @return Department
     * @throws DepartmentException
     */
    public function createDepartment(array $data) : Department
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new DepartmentException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Department
     * @throws DepartmentException
     */
    public function findDepartmentById(int $id) : Department
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new DepartmentException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws DepartmentException
     */
    public function updateDepartment(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new DepartmentException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteDepartment() : bool
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
    public function listDepartments($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
