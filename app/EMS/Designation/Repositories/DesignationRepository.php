<?php


namespace App\EMS\Designation\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Designation\Exceptions\DesignationException;
use App\EMS\Designation\Designation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class DesignationRepository extends BaseRepository implements DesignationRepositoryInterface
{
    /**
     * DesignationRepository constructor.
     *
     * @param Designation $designation
     */
    public function __construct(Designation $designation)
    {
        $this->model = $designation;
    }

    /**
     * @param array $data
     *
     * @return Designation
     * @throws DesignationException
     */
    public function createDesignation(array $data) : Designation
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new DesignationException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Designation
     * @throws DesignationException
     */
    public function findDesignationById(int $id) : Designation
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new DesignationException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws DesignationException
     */
    public function updateDesignation(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new DesignationException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteDesignation() : bool
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
    public function listDesignations($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
