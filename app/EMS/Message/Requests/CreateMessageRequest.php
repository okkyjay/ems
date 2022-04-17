<?php

namespace App\EMS\Message\Requests;


use App\EMS\BaseFormRequest;

class CreateMessageRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_one_id' => ['required'],
            'employee_two_id' => ['required'],
        ];
    }
}
