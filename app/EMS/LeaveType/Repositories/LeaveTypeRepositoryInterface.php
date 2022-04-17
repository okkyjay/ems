<?php


namespace App\EMS\LeaveType\Repositories;


use App\EMS\LeaveType\LeaveType;
use Illuminate\Support\Collection;

interface LeaveTypeRepositoryInterface
{
    public function createLeaveType(array $data): LeaveType;

    public function findLeaveTypeById(int $id) : LeaveType;

    public function updateLeaveType(array $data) : bool;

    public function deleteLeaveType() : bool;

    public function listLeaveTypes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
