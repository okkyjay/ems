<?php


namespace App\Observers;

use App\EMS\Leave\Leave;
use App\EMS\User\User;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class LeaveActionObserver
{
    public function created(Leave $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Leave'];
        $users = User::all();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
