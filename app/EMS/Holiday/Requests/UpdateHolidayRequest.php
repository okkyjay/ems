<?php

namespace App\EMS\Holiday\Requests;

use App\EMS\BaseFormRequest;

class UpdateHolidayRequest extends BaseFormRequest
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
            'start_date' => ['required'],
            'end_date' => ['required'],
        ];
    }
}
