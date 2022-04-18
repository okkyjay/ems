<?php

namespace App\EMS\Payroll\Requests;

use App\EMS\BaseFormRequest;

class UpdatePayrollRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => ['required'],
            'basic_salary' => ['required'],
            'tax_deduction' => ['required'],
            'net_salary' => ['required'],
            'month' => ['required'],
            'year' => ['required'],
            'status' => ['required'],
        ];
    }
}
