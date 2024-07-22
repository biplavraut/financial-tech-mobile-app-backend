<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'firstName' => 'bail|required|string|max:255',
            // 'middleName' => 'bail|string',
            // 'lastName' => 'bail|required|string|max:255',
            'countryCode'     => 'bail|required|string|min:2',
            'phone'     => 'bail|required|string|min:10|max:10|unique:users,phone',
            // 'email'     => 'bail|nullable|email|unique:users,email',
            'password'     => 'bail|required|string|min:8',
            'deviceName' => 'nullable|string', 
            'deviceToken' => 'nullable|string',
            'deviceType' => 'nullable|in:android,ios',
            'lat' => 'nullable|string',
            'long' => 'nullable|string',           
        ];
    }
}
