<?php


namespace App\EMS\Role\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Role\Exceptions\RoleException;
use App\EMS\Role\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * RoleRepository constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param array $data
     *
     * @return Role
     * @throws RoleException
     */
    public function createRole(array $data) : Role
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new RoleException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Role
     * @throws RoleException
     */
    public function findRoleById(int $id) : Role
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new RoleException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws RoleException
     */
    public function updateRole(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new RoleException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteRole() : bool
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
    public function listRoles($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
