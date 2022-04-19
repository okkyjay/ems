<?php


namespace App\EMS\Employee\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Employee\Employee;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function createEmployee(array $data): Employee;

    public function findEmployeeById(int $id) : Employee;

    public function updateEmployee(array $data) : bool;

    public function deleteEmployee() : bool;

    public function listEmployees($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    public function findPayrolls() : Collection;
}
