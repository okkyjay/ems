<?php


namespace App\EMS\Notification\Repositories;


use App\EMS\Notification\Notification;
use Illuminate\Support\Collection;

interface NotificationRepositoryInterface
{
    public function createNotification(array $data): Notification;

    public function findNotificationById(int $id) : Notification;

    public function updateNotification(array $data) : bool;

    public function deleteNotification() : bool;

    public function listNotifications($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}
