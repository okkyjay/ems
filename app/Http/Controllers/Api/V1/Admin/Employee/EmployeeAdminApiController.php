<?php


namespace App\Http\Controllers\Api\V1\Admin\Employee;


use App\EMS\Employee\Repositories\EmployeeRepositoryInterface;
use App\EMS\Employee\Exceptions\EmployeeException;
use App\EMS\Employee\Repositories\EmployeeRepository;
use App\EMS\Employee\Requests\CreateEmployeeRequest;
use App\EMS\Employee\Requests\UpdateEmployeeRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class EmployeeAdminApiController extends AdminBaseController
{
    private object $employeeRepo;

    public function __construct(EmployeeRepositoryInterface $employeeRepo){
        $this->employeeRepo = $employeeRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('employee_access')){
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

            $list = $this->employeeRepo->listEmployees();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("email", "LIKE", "%".$search."%");
            }

            $data = [
                'employee' => $this->employeeRepo->paginateArrayResults($list->all(), $per_page, $page),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure ".$exception->getMessage());
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
            $employee = $this->employeeRepo->findEmployeeById($id);
            if ($employee){
                $data = ['employee' => $employee];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateEmployeeRequest $request)
    {
        try {
            $request->merge([
                'status' => 1,
                'password' => bcrypt($request->input('password'))
            ]);
            $employee = $this->employeeRepo->createEmployee($request->all());
            $data = ['employee' =>  $employee = $this->employeeRepo->findEmployeeById($employee->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            return $this->failed("Unknown Failure".$exception->getMessage());
        }
    }

    public function update(UpdateEmployeeRequest $request, int $id)
    {
        try {
            $employee = $this->employeeRepo->findEmployeeById($id);
            if ($employee){

                $employeeUpdate = new EmployeeRepository($employee);
                try {
                    $employeeUpdate->updateEmployee($request->all());
                } catch (EmployeeException $e) {
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'employee' => $this->employeeRepo->findEmployeeById($id)
                ];
                return $this->success($data,'Record Updated');
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
            $employee = $this->employeeRepo->findEmployeeById($id);
            if ($employee) {
                $employeeDelete = new EmployeeRepository($employee);
                $employeeDelete->deleteEmployee();
                return $this->success([], "Success");
            }else{
                return $this->notFound("Record Not Found");
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
