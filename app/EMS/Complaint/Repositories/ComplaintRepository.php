<?php


namespace App\EMS\Complaint\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Complaint\Exceptions\ComplaintException;
use App\EMS\Complaint\Complaint;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ComplaintRepository extends BaseRepository implements ComplaintRepositoryInterface
{
    /**
     * ComplaintRepository constructor.
     *
     * @param Complaint $complaint
     */
    public function __construct(Complaint $complaint)
    {
        parent::__construct($complaint);
        $this->model = $complaint;
    }

    /**
     * @param array $data
     *
     * @return Complaint
     * @throws ComplaintException
     */
    public function createComplaint(array $data) : Complaint
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new ComplaintException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Complaint
     * @throws ComplaintException
     */
    public function findComplaintById(int $id) : Complaint
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ComplaintException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws ComplaintException
     */
    public function updateComplaint(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new ComplaintException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteComplaint() : bool
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
    public function listComplaints($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
