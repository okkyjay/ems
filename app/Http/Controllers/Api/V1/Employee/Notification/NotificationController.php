<?php


namespace App\Http\Controllers\Api\V1\Employee\Notification;


use App\EMS\Notification\Exceptions\NotificationException;
use App\EMS\Notification\Repositories\NotificationRepository;
use App\EMS\Notification\Repositories\NotificationRepositoryInterface;
use App\EMS\Notification\Requests\UpdateNotificationRequest;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use Illuminate\Http\Request;

class NotificationController extends EmployeeBaseController
{
    private object $notificationRepo;

    public function __construct(NotificationRepositoryInterface $notificationRepository){
        $this->notificationRepo = $notificationRepository;
    }

    public function index(Request $request)
    {
        try {
            $loggedInEmployee = $this->user();

            $page = $request->input('page', 1);
            $query = ['employee_id' => $loggedInEmployee->id];
            $list = $this->notificationRepo->listEmployeeNotifications($query);

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'notifications' => $this->notificationRepo->paginateArrayResults($list->all()),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */

    public function show(int $id)
    {
        try {
            $notification = $this->notificationRepo->findNotificationById($id);
            if ($notification && $notification->employee_id == $this->user()->id){
                $data = ['notification' => $notification];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }


    public function update(UpdateNotificationRequest $request, int $id)
    {
        try {
            $notification = $this->notificationRepo->findNotificationById($id);
            if ($notification && $notification->employee_id == $this->user()->id){

                $notificationUpdate = new NotificationRepository($notification);
                try {
                    $notificationUpdate->updateNotification($request->all());
                } catch (NotificationException $e) {
                }
                $data = [];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }


    public function destroy(int $id)
    {
        try {
            $notification = $this->notificationRepo->findNotificationById($id);
            if ($notification && $notification->employee_id == $this->user()->id) {
                $notificationDelete = new NotificationRepository($notification);
                $notificationDelete->deleteNotification();
                return $this->success([]);
            }else{
                return $this->notFound("Forbidden");
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
