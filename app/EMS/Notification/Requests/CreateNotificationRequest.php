<?php

namespace App\EMS\Notification\Requests;


use App\EMS\BaseFormRequest;

class CreateNotificationRequest extends BaseFormRequest
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
            'body' => ['required'],
            'employee_id' => ['required'],
        ];
    }
}
