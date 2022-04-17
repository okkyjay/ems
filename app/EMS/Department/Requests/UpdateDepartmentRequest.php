<?php

namespace App\EMS\Department\Requests;

use App\EMS\BaseFormRequest;

class UpdateDepartmentRequest extends BaseFormRequest
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
