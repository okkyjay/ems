<?php


namespace App\Http\Controllers\Api\V1\Admin\Department;


use App\EMS\Department\Repositories\DepartmentRepositoryInterface;
use App\EMS\Department\Exceptions\DepartmentException;
use App\EMS\Department\Repositories\DepartmentRepository;
use App\EMS\Department\Requests\CreateDepartmentRequest;
use App\EMS\Department\Requests\UpdateDepartmentRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class DepartmentAdminApiController extends AdminBaseController
{
    private object $departmentRepo;

    public function __construct(DepartmentRepositoryInterface $departmentRepo){
        $this->departmentRepo = $departmentRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('department_access')){
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

            $list = $this->departmentRepo->listDepartments();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("email", "LIKE", "%".$search."%");
            }

            $data = [
                'department' => $this->departmentRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $department = $this->departmentRepo->findDepartmentById($id);
            if ($department){
                $data = ['department' => $department];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateDepartmentRequest $request)
    {
        try {
            $department = $this->departmentRepo->createDepartment($request->except('attachment'));
            $data = ['department' =>  $department = $this->departmentRepo->findDepartmentById($department->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateDepartmentRequest $request, int $id)
    {
        try {
            $department = $this->departmentRepo->findDepartmentById($id);
            if ($department){

                $departmentUpdate = new DepartmentRepository($department);
                try {
                    $departmentUpdate->updateDepartment($request->except('attachment'));
                } catch (DepartmentException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'department' => $this->departmentRepo->findDepartmentById($id)
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
            $department = $this->departmentRepo->findDepartmentById($id);
            if ($department) {
                $departmentDelete = new DepartmentRepository($department);
                $departmentDelete->deleteDepartment();
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
