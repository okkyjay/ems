<?php


namespace App\EMS\Complaint\Repositories;


use App\EMS\Complaint\Complaint;
use Illuminate\Support\Collection;

interface ComplaintRepositoryInterface
{
    public function createComplaint(array $data): Complaint;

    public function findComplaintById(int $id) : Complaint;

    public function updateComplaint(array $data) : bool;

    public function deleteComplaint() : bool;

    public function listComplaints($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
