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
            'email' => ['required','unique:employees'],
            'password' => ['required','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@^&*_+()]).*$/'],
            'phone_number' => ['required'],
            'employee_number' => ['required','unique:employees'],
            'gender' => ['required'],
/*            'address' => ['required'],
            'basic_salary' => ['required'],
            'bank_account_number' => ['required'],
            'bank_account_name' => ['required'],
            'department_id' => ['required'],
            'bank_id' => ['required'],
            'state_id' => ['required'],
            'country_id' => ['required'],
            'status' => ['required'],
            'date_of_birth' => ["required"]*/
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least one number and both uppercase and lowercase letters and one special character.',
        ];

    }
}
