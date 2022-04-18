<?php


namespace App\Http\Controllers\Api\V1\Employee\Payroll;


use App\EMS\Employee\Repositories\EmployeeRepositoryInterface;
use App\EMS\Payroll\Repositories\PayrollRepositoryInterface;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use Illuminate\Http\Request;

class PayrollController extends EmployeeBaseController
{
    private object $payrollRepo;

    public function __construct(PayrollRepositoryInterface $payrollRepository){
        $this->payrollRepo = $payrollRepository;
    }

    public function index(Request $request)
    {
        try {
            $loggedInEmployee = $this->user();

            $page = $request->input('page', 1);
            $query = ['employee_id' => $loggedInEmployee->id];
            $list = $this->payrollRepo->listEmployeePayrolls($query);

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("basic_salary", "LIKE", "%".$search."%");
            }

            $data = [
                'payrolls' => $this->payrollRepo->paginateArrayResults($list->all()),
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
            $payroll = $this->payrollRepo->findPayrollById($id);
            if ($payroll && $payroll->employee_id == $this->user()->id){
                $data = ['payroll' => $payroll];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
