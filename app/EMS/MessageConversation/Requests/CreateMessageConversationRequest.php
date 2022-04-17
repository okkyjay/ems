<?php

namespace App\EMS\MessageConversation\Requests;


use App\EMS\BaseFormRequest;

class CreateMessageConversationRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chat_employee_id' => ['required'],
            'message_id' => ['required'],
            'message' => ['required'],
            'is_read' => ['is_read'],
        ];
    }
}
