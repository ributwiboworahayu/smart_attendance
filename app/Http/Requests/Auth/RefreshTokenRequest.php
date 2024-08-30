<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequestResponse;
use Illuminate\Contracts\Validation\ValidationRule;

class RefreshTokenRequest extends FormRequestResponse
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }
}
