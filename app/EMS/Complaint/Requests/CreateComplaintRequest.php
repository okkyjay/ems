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
            'title' => ['required'],
            'description' => ['required'],
            'employee_id' => ['required'],
        ];
    }
}
