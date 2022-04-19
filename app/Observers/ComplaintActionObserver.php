<?php


namespace App\Observers;


use App\EMS\Complaint\Complaint;
use App\EMS\User\User;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class ComplaintActionObserver
{
    public function created(Complaint $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Complaint'];
        $users = User::all();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
