<?php


namespace App\EMS\Notification\Repositories;


use App\EMS\BaseRepository;
use App\EMS\Notification\Exceptions\NotificationException;
use App\EMS\Notification\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    /**
     * NotificationRepository constructor.
     *
     * @param Notification $notificaton
     */
    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    /**
     * @param array $data
     *
     * @return Notification
     * @throws NotificationException
     */
    public function createNotification(array $data) : Notification
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new NotificationException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Notification
     * @throws NotificationException
     */
    public function findNotificationById(int $id)
    {
        try {
            return $this->find($id);
        } catch (ModelNotFoundException $e) {
            throw new NotificationException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws NotificationException
     */
    public function updateNotification(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new NotificationException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteNotification() : bool
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
    public function listNotifications($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @param array $query
     *
     * @return Collection
     */
    public function listEmployeeNotifications(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->where($query, $columns, $orderBy, $sortBy);
    }
}
