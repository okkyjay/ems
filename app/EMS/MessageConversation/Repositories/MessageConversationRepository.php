<?php


namespace App\EMS\MessageConversation\Repositories;


use App\EMS\BaseRepository;
use App\EMS\MessageConversation\Exceptions\MessageConversationException;
use App\EMS\MessageConversation\MessageConversation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class MessageConversationRepository extends BaseRepository implements MessageConversationRepositoryInterface
{
    /**
     * MessageConversationRepository constructor.
     *
     * @param MessageConversation $state
     */
    public function __construct(MessageConversation $state)
    {
        parent::__construct($state);
        $this->model = $state;
    }

    /**
     * @param array $data
     *
     * @return MessageConversation
     * @throws MessageConversationException
     */
    public function createMessageConversation(array $data) : MessageConversation
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new MessageConversationException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return MessageConversation
     * @throws MessageConversationException
     */
    public function findMessageConversationById(int $id) : MessageConversation
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new MessageConversationException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws MessageConversationException
     */
    public function updateMessageConversation(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new MessageConversationException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteMessageConversation() : bool
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
    public function listMessageConversations($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
