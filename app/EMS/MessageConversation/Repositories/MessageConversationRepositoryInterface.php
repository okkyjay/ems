<?php


namespace App\EMS\MessageConversation\Repositories;


use App\EMS\MessageConversation\MessageConversation;
use Illuminate\Support\Collection;

interface MessageConversationRepositoryInterface
{
    public function createMessageConversation(array $data): MessageConversation;

    public function findMessageConversationById(int $id) : MessageConversation;

    public function updateMessageConversation(array $data) : bool;

    public function deleteMessageConversation() : bool;

    public function listMessageConversations($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
