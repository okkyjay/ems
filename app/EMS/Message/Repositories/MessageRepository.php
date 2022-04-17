<?php


namespace App\EMS\Message\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Message\Exceptions\MessageException;
use App\EMS\Message\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    /**
     * MessageRepository constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        parent::__construct($message);
        $this->model = $message;
    }

    /**
     * @param array $data
     *
     * @return Message
     * @throws MessageException
     */
    public function createMessage(array $data) : Message
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new MessageException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Message
     * @throws MessageException
     */
    public function findMessageById(int $id) : Message
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new MessageException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws MessageException
     */
    public function updateMessage(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new MessageException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteMessage() : bool
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
    public function listMessages($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
