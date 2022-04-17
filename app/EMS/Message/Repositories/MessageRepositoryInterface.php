<?php


namespace App\EMS\Message\Repositories;


use App\EMS\Message\Message;
use Illuminate\Support\Collection;

interface MessageRepositoryInterface
{
    public function createMessage(array $data): Message;

    public function findMessageById(int $id) : Message;

    public function updateMessage(array $data) : bool;

    public function deleteMessage() : bool;

    public function listMessages($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
