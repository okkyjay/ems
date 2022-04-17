<?php


namespace App\EMS\Permission\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Permission\Exceptions\PermissionException;
use App\EMS\Permission\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * PermissionRepository constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
        $this->model = $permission;
    }

    /**
     * @param array $data
     *
     * @return Permission
     * @throws PermissionException
     */
    public function createPermission(array $data) : Permission
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new PermissionException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Permission
     * @throws PermissionException
     */
    public function findPermissionById(int $id) : Permission
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PermissionException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws PermissionException
     */
    public function updatePermission(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new PermissionException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deletePermission() : bool
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
    public function listPermissions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
