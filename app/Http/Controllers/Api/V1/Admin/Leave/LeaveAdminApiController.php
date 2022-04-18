<?php


namespace App\Http\Controllers\Api\V1\Admin\Leave;


use App\EMS\Leave\Repositories\LeaveRepositoryInterface;
use App\EMS\Leave\Exceptions\LeaveException;
use App\EMS\Leave\Repositories\LeaveRepository;
use App\EMS\Leave\Requests\CreateLeaveRequest;
use App\EMS\Leave\Requests\UpdateLeaveRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class LeaveAdminApiController extends AdminBaseController
{
    private object $leaveRepo;

    public function __construct(LeaveRepositoryInterface $leaveRepo){
        $this->leaveRepo = $leaveRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('leave_access')){
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

            $list = $this->leaveRepo->listLeaves();

            $data = [
                'leave' => $this->leaveRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $leave = $this->leaveRepo->findLeaveById($id);
            if ($leave){
                $data = ['leave' => $leave];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateLeaveRequest $request)
    {
        try {
            $leave = $this->leaveRepo->createLeave($request->except('attachment'));
            $data = ['leave' =>  $leave = $this->leaveRepo->findLeaveById($leave->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateLeaveRequest $request, int $id)
    {
        try {
            $leave = $this->leaveRepo->findLeaveById($id);
            if ($leave){

                $leaveUpdate = new LeaveRepository($leave);
                try {
                    $leaveUpdate->updateLeave($request->except('attachment'));
                } catch (LeaveException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'leave' => $this->leaveRepo->findLeaveById($id)
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
            $leave = $this->leaveRepo->findLeaveById($id);
            if ($leave) {
                $leaveDelete = new LeaveRepository($leave);
                $leaveDelete->deleteLeave();
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
