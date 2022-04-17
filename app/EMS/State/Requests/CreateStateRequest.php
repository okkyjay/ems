<?php

namespace App\EMS\State\Requests;


use App\EMS\BaseFormRequest;

class CreateStateRequest extends BaseFormRequest
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
            'country_id' => ['required'],
            'status' => ['required'],
        ];
    }
}
