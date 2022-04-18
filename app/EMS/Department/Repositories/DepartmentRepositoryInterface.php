<?php


namespace App\EMS\Department\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Department\Department;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface extends BaseRepositoryInterface
{
    public function createDepartment(array $data): Department;

    public function findDepartmentById(int $id) : Department;

    public function updateDepartment(array $data) : bool;

    public function deleteDepartment() : bool;

    public function listDepartments($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
