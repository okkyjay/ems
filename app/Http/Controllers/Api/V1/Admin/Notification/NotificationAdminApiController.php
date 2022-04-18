<?php


namespace App\Http\Controllers\Api\V1\Admin\Notification;


use App\EMS\Notification\Repositories\NotificationRepositoryInterface;
use App\EMS\Notification\Exceptions\NotificationException;
use App\EMS\Notification\Repositories\NotificationRepository;
use App\EMS\Notification\Requests\CreateNotificationRequest;
use App\EMS\Notification\Requests\UpdateNotificationRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class NotificationAdminApiController extends AdminBaseController
{
    private object $notificationRepo;

    public function __construct(NotificationRepositoryInterface $notificationRepo){
        $this->notificationRepo = $notificationRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('notification_access')){
                return $this->forbidden();
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $per_page = $request->input('per_page', 20);

            $list = $this->notificationRepo->listNotifications();


            $data = [
                'notification' => $this->notificationRepo->paginateArrayResults($list->all(), $per_page, $page),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure ");
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
            if ($notification){
                $data = ['notification' => $notification];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateNotificationRequest $request)
    {
        try {
            $notification = $this->notificationRepo->createNotification($request->except('attachment'));
            $data = ['notification' =>  $notification = $this->notificationRepo->findNotificationById($notification->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateNotificationRequest $request, int $id)
    {
        try {
            $notification = $this->notificationRepo->findNotificationById($id);
            if ($notification){

                $notificationUpdate = new NotificationRepository($notification);
                try {
                    $notificationUpdate->updateNotification($request->except('attachment'));
                } catch (NotificationException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'notification' => $this->notificationRepo->findNotificationById($id)
                ];
                return $this->success($data,'Record Updated');
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function destroy(int $id)
    {
        try {
            $notification = $this->notificationRepo->findNotificationById($id);
            if ($notification) {
                $notificationDelete = new NotificationRepository($notification);
                $notificationDelete->deleteNotification();
                return $this->success([], "Success");
            }else{
                return $this->notFound("Record Not Found");
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }
}
