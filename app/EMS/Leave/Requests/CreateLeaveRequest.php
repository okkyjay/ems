<?php

namespace App\EMS\Leave\Requests;


use App\EMS\BaseFormRequest;

class CreateLeaveRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leave_from' => ['required'],
            'leave_to' => ['required'],
            'employee_remark' => ['required'],
            'leave_type_id' => ['required'],
            'employee_id' => ['required'],
        ];
    }
}
