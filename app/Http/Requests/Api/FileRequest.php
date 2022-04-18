<?php

namespace App\Http\Requests\Api;

use App\User;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class FileRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }
    protected function failedValidation(Validator $validator)
    {

        if (\Request::is('api/*')){
            $error = array(
                'error' => $validator->errors(),
                'status' => false
            );
            throw new HttpResponseException(response()->json($error, 403));
        } else{
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,ppt,pptx,mp4,flv,mov,wmv,3gp',
        ];

    }
}
