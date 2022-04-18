<?php


namespace App\EMS\Designation\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Designation\Designation;
use Illuminate\Support\Collection;

interface DesignationRepositoryInterface extends BaseRepositoryInterface
{
    public function createDesignation(array $data): Designation;

    public function findDesignationById(int $id) : Designation;

    public function updateDesignation(array $data) : bool;

    public function deleteDesignation() : bool;

    public function listDesignations($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
