<?php


namespace App\EMS\User\Repositories;


use App\EMS\User\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;

    public function findUserById(int $id) : User;

    public function updateUser(array $data) : bool;

    public function deleteUser() : bool;

    public function listUsers($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
