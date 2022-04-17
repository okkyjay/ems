<?php

namespace App\EMS\User\Requests;

use App\EMS\BaseFormRequest;

class UpdateUserRequest extends BaseFormRequest
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
            'email' => ['required','unique:users'],
            'password' => ['required'],
            'role_id' => ['required'],
        ];
    }
}
