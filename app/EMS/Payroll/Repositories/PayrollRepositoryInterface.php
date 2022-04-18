<?php


namespace App\EMS\Payroll\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Payroll\Payroll;
use Illuminate\Support\Collection;

interface PayrollRepositoryInterface extends BaseRepositoryInterface
{
    public function createPayroll(array $data): Payroll;

    public function findPayrollById(int $id) ;

    public function updatePayroll(array $data) : bool;

    public function deletePayroll() : bool;

    public function listPayrolls($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    public function listEmployeePayrolls(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

}
