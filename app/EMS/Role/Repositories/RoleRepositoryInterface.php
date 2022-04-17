<?php


namespace App\EMS\Role\Repositories;


use App\EMS\Role\Role;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
    public function createRole(array $data): Role;

    public function findRoleById(int $id) : Role;

    public function updateRole(array $data) : bool;

    public function deleteRole() : bool;

    public function listRoles($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
