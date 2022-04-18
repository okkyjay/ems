<?php


namespace App\EMS\Permission\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Permission\Permission;
use Illuminate\Support\Collection;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function createPermission(array $data): Permission;

    public function findPermissionById(int $id) ;

    public function updatePermission(array $data) : bool;

    public function deletePermission() : bool;

    public function listPermissions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
