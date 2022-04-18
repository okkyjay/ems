<?php

namespace App\EMS\Employee\Requests;

use App\EMS\BaseFormRequest;

class UpdateEmployeeRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required','unique:users,email'],
            'employee_number' => ['required'],
        ];
    }
}
