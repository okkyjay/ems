<?php


namespace App\EMS\Payroll\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Payroll\Exceptions\PayrollException;
use App\EMS\Payroll\Payroll;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class PayrollRepository extends BaseRepository implements PayrollRepositoryInterface
{
    /**
     * PayrollRepository constructor.
     *
     * @param Payroll $payroll
     */
    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->model = $payroll;
    }

    /**
     * @param array $data
     *
     * @return Payroll
     * @throws PayrollException
     */
    public function createPayroll(array $data) : Payroll
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new PayrollException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Payroll
     * @throws PayrollException
     */
    public function findPayrollById(int $id) : Payroll
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PayrollException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws PayrollException
     */
    public function updatePayroll(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new PayrollException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deletePayroll() : bool
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
    public function listPayrolls($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function listEmployeePayrolls(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'):Collection
    {
        return $this->where($query, $columns, $orderBy, $sortBy);
    }
}
