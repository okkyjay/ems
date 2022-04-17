<?php

namespace App\EMS\Permission\Requests;

use App\EMS\BaseFormRequest;

class UpdatePermissionRequest extends BaseFormRequest
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
