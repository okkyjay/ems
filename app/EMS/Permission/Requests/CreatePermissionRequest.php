<?php

namespace App\EMS\Permission\Requests;


use App\EMS\BaseFormRequest;

class CreatePermissionRequest extends BaseFormRequest
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
        ];
    }
}
