<?php


namespace App\Http\Controllers\Api\V1\Admin\LeaveType;


use App\EMS\LeaveType\Repositories\LeaveTypeRepositoryInterface;
use App\EMS\LeaveType\Exceptions\LeaveTypeException;
use App\EMS\LeaveType\Repositories\LeaveTypeRepository;
use App\EMS\LeaveType\Requests\CreateLeaveTypeRequest;
use App\EMS\LeaveType\Requests\UpdateLeaveTypeRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class LeaveTypeAdminApiController extends AdminBaseController
{
    private object $leaveTypeRepo;

    public function __construct(LeaveTypeRepositoryInterface $leaveTypeRepo){
        $this->leaveTypeRepo = $leaveTypeRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('leave_type_access')){
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

            $list = $this->leaveTypeRepo->listLeaveTypes();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("email", "LIKE", "%".$search."%");
            }

            $data = [
                'leaveType' => $this->leaveTypeRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $leaveType = $this->leaveTypeRepo->findLeaveTypeById($id);
            if ($leaveType){
                $data = ['leaveType' => $leaveType];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateLeaveTypeRequest $request)
    {
        try {
            $leaveType = $this->leaveTypeRepo->createLeaveType($request->except('attachment'));
            $data = ['leaveType' =>  $leaveType = $this->leaveTypeRepo->findLeaveTypeById($leaveType->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateLeaveTypeRequest $request, int $id)
    {
        try {
            $leaveType = $this->leaveTypeRepo->findLeaveTypeById($id);
            if ($leaveType){

                $leaveTypeUpdate = new LeaveTypeRepository($leaveType);
                try {
                    $leaveTypeUpdate->updateLeaveType($request->except('attachment'));
                } catch (LeaveTypeException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'leaveType' => $this->leaveTypeRepo->findLeaveTypeById($id)
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
            $leaveType = $this->leaveTypeRepo->findLeaveTypeById($id);
            if ($leaveType) {
                $leaveTypeDelete = new LeaveTypeRepository($leaveType);
                $leaveTypeDelete->deleteLeaveType();
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
