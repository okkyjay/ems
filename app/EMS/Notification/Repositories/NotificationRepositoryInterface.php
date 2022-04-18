<?php


namespace App\EMS\Notification\Repositories;


use App\EMS\BaseRepositoryInterface;
use App\EMS\Notification\Notification;
use Illuminate\Support\Collection;

interface NotificationRepositoryInterface extends BaseRepositoryInterface
{
    public function createNotification(array $data): Notification;

    public function findNotificationById(int $id) ;

    public function updateNotification(array $data) : bool;

    public function deleteNotification() : bool;

    public function listNotifications($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    public function listEmployeeNotifications(array $query, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
