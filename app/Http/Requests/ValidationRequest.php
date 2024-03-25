<?php

namespace App\Http\Requests;

use App\Utils\WebResponseUtils;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidationRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(WebResponseUtils::base($validator->errors(), "Invalid Request Data", 422));
    }
}
