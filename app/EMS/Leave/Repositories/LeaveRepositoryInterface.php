<?php


namespace App\EMS\Leave\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Leave\Leave;
use Illuminate\Support\Collection;

interface LeaveRepositoryInterface extends BaseRepositoryInterface
{
    public function createLeave(array $data): Leave;

    public function findLeaveById(int $id) : Leave;

    public function updateLeave(array $data) : bool;

    public function deleteLeave() : bool;

    public function listLeaves($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    public function listEmployeeLeaves(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
