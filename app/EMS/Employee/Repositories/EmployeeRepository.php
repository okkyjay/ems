<?php


namespace App\EMS\Employee\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Employee\Exceptions\EmployeeException;
use App\EMS\Employee\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $user
     */
    public function __construct(Employee $user)
    {
        $this->model = $user;
    }

    /**
     * @param array $data
     *
     * @return Employee
     * @throws EmployeeException
     */
    public function createEmployee(array $data) : Employee
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new EmployeeException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Employee
     * @throws EmployeeException
     */
    public function findEmployeeById(int $id) : Employee
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new EmployeeException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws EmployeeException
     */
    public function updateEmployee(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new EmployeeException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteEmployee() : bool
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
    public function listEmployees($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * Return all the Payrolls associated with the Employee
     *
     * @return mixed
     */
    public function findPayrolls() : Collection
    {
        return $this->model->payrolls;
    }

    /**
     * Return all the Complain associated with the Employee
     *
     * @return mixed
     */
    public function findComplaints() : Collection
    {
        return $this->model->complaints;
    }

    /**
     * Return all the leaves associated with the Employee
     *
     * @return mixed
     */
    public function findLeaves() : Collection
    {
        return $this->model->leaves;
    }
}
