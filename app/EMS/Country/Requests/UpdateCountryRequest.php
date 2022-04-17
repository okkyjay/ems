<?php

namespace App\EMS\Country\Requests;

use App\EMS\BaseFormRequest;

class UpdateCountryRequest extends BaseFormRequest
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
