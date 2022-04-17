<?php

namespace App\EMS\Complaint\Requests;


use App\EMS\BaseFormRequest;

class CreateComplaintRequest extends BaseFormRequest
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
