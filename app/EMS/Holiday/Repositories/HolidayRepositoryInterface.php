<?php


namespace App\EMS\Holiday\Repositories;


use App\EMS\Holiday\Holiday;
use Illuminate\Support\Collection;

interface HolidayRepositoryInterface
{
    public function createHoliday(array $data): Holiday;

    public function findHolidayById(int $id) : Holiday;

    public function updateHoliday(array $data) : bool;

    public function deleteHoliday() : bool;

    public function listHolidays($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
