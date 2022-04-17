<?php


namespace App\EMS\Holiday\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Holiday\Exceptions\HolidayException;
use App\EMS\Holiday\Holiday;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class HolidayRepository extends BaseRepository implements HolidayRepositoryInterface
{
    /**
     * HolidayRepository constructor.
     *
     * @param Holiday $holiday
     */
    public function __construct(Holiday $holiday)
    {
        parent::__construct($holiday);
        $this->model = $holiday;
    }

    /**
     * @param array $data
     *
     * @return Holiday
     * @throws HolidayException
     */
    public function createHoliday(array $data) : Holiday
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new HolidayException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Holiday
     * @throws HolidayException
     */
    public function findHolidayById(int $id) : Holiday
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HolidayException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws HolidayException
     */
    public function updateHoliday(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new HolidayException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteHoliday() : bool
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
    public function listHolidays($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
