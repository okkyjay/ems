<?php


namespace App\EMS;


use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * @param array $data
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginateArrayResults(array $data, int $perPage = 50, $page = 1);
}
