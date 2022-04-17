<?php

namespace App\EMS\LeaveType\Requests;


use App\EMS\BaseFormRequest;

class CreateLeaveTypeRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'status' => ['required'],
        ];
    }
}
