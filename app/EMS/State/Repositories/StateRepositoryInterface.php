<?php


namespace App\EMS\State\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\State\State;
use Illuminate\Support\Collection;

interface StateRepositoryInterface extends BaseRepositoryInterface
{
    public function createState(array $data): State;

    public function findStateById(int $id) : State;

    public function updateState(array $data) : bool;

    public function deleteState() : bool;

    public function listStates($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
