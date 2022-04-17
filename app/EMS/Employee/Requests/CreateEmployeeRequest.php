<?php

namespace App\EMS\Employee\Requests;


use App\EMS\BaseFormRequest;

class CreateEmployeeRequest extends BaseFormRequest
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
            'email' => ['required','unique:users'],
            'password' => ['required'],
            'phone_number' => ['required'],
            'employee_number' => ['required'],
            'gender' => ['required'],
            'address' => ['required'],
            'basic_salary' => ['required'],
            'access_code' => ['required'],
            'bank_account_number' => ['required'],
            'bank_account_name' => ['required'],
            'department_id' => ['required'],
            'bank_id' => ['required'],
            'state_id' => ['required'],
            'country_id' => ['required'],
            'status' => ['required'],
            'date_of_birth' => ["required"]
        ];
    }
}
