<?php


namespace App\EMS\Leave\Repositories;


use App\EMS\Leave\Leave;
use Illuminate\Support\Collection;

interface LeaveRepositoryInterface
{
    public function createLeave(array $data): Leave;

    public function findLeaveById(int $id) : Leave;

    public function updateLeave(array $data) : bool;

    public function deleteLeave() : bool;

    public function listLeaves($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}