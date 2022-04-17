<?php


namespace App\Http\Controllers\Api\V1\Employee;


use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class EmployeeBaseController extends BaseController
{
    /**
     * logged in employee
     *
     */

    public function user()
    {
        return Auth::guard('employee')->user();
    }
}
