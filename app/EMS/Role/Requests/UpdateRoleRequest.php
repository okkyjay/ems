<?php

namespace App\EMS\Role\Requests;

use App\EMS\BaseFormRequest;

class UpdateRoleRequest extends BaseFormRequest
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
