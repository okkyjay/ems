<?php

namespace App\EMS\Designation\Requests;


use App\EMS\BaseFormRequest;

class CreateDesignationRequest extends BaseFormRequest
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
