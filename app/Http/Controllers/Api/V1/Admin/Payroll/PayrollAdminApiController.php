<?php


namespace App\Http\Controllers\Api\V1\Admin\Payroll;


use App\EMS\Payroll\Repositories\PayrollRepositoryInterface;
use App\EMS\Payroll\Exceptions\PayrollException;
use App\EMS\Payroll\Repositories\PayrollRepository;
use App\EMS\Payroll\Requests\CreatePayrollRequest;
use App\EMS\Payroll\Requests\UpdatePayrollRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class PayrollAdminApiController extends AdminBaseController
{
    private object $payrollRepo;

    public function __construct(PayrollRepositoryInterface $payrollRepo){
        $this->payrollRepo = $payrollRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('payroll_access')){
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

            $list = $this->payrollRepo->listPayrolls();


            $data = [
                'payroll' => $this->payrollRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $payroll = $this->payrollRepo->findPayrollById($id);
            if ($payroll){
                $data = ['payroll' => $payroll];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreatePayrollRequest $request)
    {
        try {
            $request->merge([
                'status' => 1
            ]);
            $payroll = $this->payrollRepo->createPayroll($request->except('attachment'));
            $data = ['payroll' =>  $payroll = $this->payrollRepo->findPayrollById($payroll->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdatePayrollRequest $request, int $id)
    {
        try {
            $payroll = $this->payrollRepo->findPayrollById($id);
            if ($payroll){

                $payrollUpdate = new PayrollRepository($payroll);
                try {
                    $payrollUpdate->updatePayroll($request->except('attachment'));
                } catch (PayrollException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'payroll' => $this->payrollRepo->findPayrollById($id)
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
            $payroll = $this->payrollRepo->findPayrollById($id);
            if ($payroll) {
                $payrollDelete = new PayrollRepository($payroll);
                $payrollDelete->deletePayroll();
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
