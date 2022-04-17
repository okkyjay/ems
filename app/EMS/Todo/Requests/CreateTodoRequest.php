<?php

namespace App\EMS\Todo\Requests;


use App\EMS\BaseFormRequest;

class CreateTodoRequest extends BaseFormRequest
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
            'employee_id' => ['required'],
            'due_date' => ['required'],
        ];
    }
}
