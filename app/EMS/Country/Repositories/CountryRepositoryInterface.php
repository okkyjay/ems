<?php


namespace App\EMS\Country\Repositories;


use App\EMS\Country\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function createCountry(array $data): Country;

    public function findCountryById(int $id) : Country;

    public function updateCountry(array $data) : bool;

    public function deleteCountry() : bool;

    public function listCountries($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
