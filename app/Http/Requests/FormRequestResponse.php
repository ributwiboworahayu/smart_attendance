<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequestResponse extends FormRequest
{
    use ApiResponser;

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        $response = $this->failResponse(
            data: $validator->errors(),
            code: 422,
            message: $validator->errors()->first()
        );
        throw new HttpResponseException($response);
    }
}
