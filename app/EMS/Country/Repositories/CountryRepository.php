<?php


namespace App\EMS\Country\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Country\Exceptions\CountryException;
use App\EMS\Country\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    /**
     * CountryRepository constructor.
     *
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    /**
     * @param array $data
     *
     * @return Country
     * @throws CountryException
     */
    public function createCountry(array $data) : Country
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CountryException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Country
     * @throws CountryException
     */
    public function findCountryById(int $id) : Country
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CountryException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws CountryException
     */
    public function updateCountry(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new CountryException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCountry() : bool
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
    public function listCountries($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
