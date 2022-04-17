<?php


namespace App\EMS\Permission\Repositories;


use App\EMS\Permission\Permission;
use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
    public function createPermission(array $data): Permission;

    public function findPermissionById(int $id) : Permission;

    public function updatePermission(array $data) : bool;

    public function deletePermission() : bool;

    public function listPermissions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
