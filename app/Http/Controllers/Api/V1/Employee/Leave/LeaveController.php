<?php


namespace App\Http\Controllers\Api\V1\Employee\Leave;


use App\EMS\Leave\Exceptions\LeaveException;
use App\EMS\Leave\Repositories\LeaveRepository;
use App\EMS\Leave\Repositories\LeaveRepositoryInterface;
use App\EMS\Leave\Requests\CreateLeaveRequest;
use App\EMS\Leave\Requests\UpdateLeaveRequest;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use Illuminate\Http\Request;

class LeaveController extends EmployeeBaseController
{
    private object $leaveRepo;

    public function __construct(LeaveRepositoryInterface $leaveRepository){
        $this->leaveRepo = $leaveRepository;
    }

    public function index(Request $request)
    {
        try {
            $loggedInEmployee = $this->user();

            $page = $request->input('page', 1);
            $query = ['employee_id' => $loggedInEmployee->id];
            $list = $this->leaveRepo->listEmployeeLeaves($query);

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'leaves' => $this->leaveRepo->paginateArrayResults($list->all()),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateLeaveRequest $request)
    {
        try {
            $loggedInEmployee = $this->user();
            if ((int)$loggedInEmployee->id === (int)$request->input('employee_id')){
                $leave = $this->leaveRepo->createLeave($request->all());
                if ($request->input('attachment')){
                    $this->storeMediaFiles($leave, $request->input('attachment'), 'attachment');
                }
                $data = ['leave' => $leave];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        } catch (\Exception $exception){
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
            $leave = $this->leaveRepo->findLeaveById($id);
            if ($leave && $leave->employee_id == $this->user()->id){
                $data = ['leave' => $leave];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateLeaveRequest $request, int $id)
    {
        try {
            $leave = $this->leaveRepo->findLeaveById($id);
            if ($leave && $leave->employee_id == $this->user()->id){

                $leaveUpdate = new LeaveRepository($leave);
                try {
                    $leaveUpdate->updateLeave($request->all());
                    if ($request->input('attachment')){
                        $this->storeMediaFiles($leave, $request->input('attachment'), 'attachment');
                    }
                } catch (LeaveException $e) {
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
            $leave = $this->leaveRepo->findLeaveById($id);
            if ($leave && $leave->employee_id == $this->user()->id) {
                $leaveDelete = new LeaveRepository($leave);
                $leaveDelete->deleteLeave();
                return $this->success([]);
            }else{
                return $this->notFound("Forbidden");
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
