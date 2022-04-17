<?php


namespace App\EMS\User\Repositories;


use App\EMS\BaseRepository;
use App\EMS\User\Exceptions\UserException;
use App\EMS\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }

    /**
     * @param array $data
     *
     * @return User
     * @throws UserException
     */
    public function createUser(array $data) : User
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new UserException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws UserException
     */
    public function findUserById(int $id) : User
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UserException
     */
    public function updateUser(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UserException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteUser() : bool
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
    public function listUsers($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
