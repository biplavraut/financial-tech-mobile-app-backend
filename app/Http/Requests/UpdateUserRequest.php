<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'salutation' => 'nullable|string',
            'firstName' => 'bail|nullable|string|max:255',
            'middleName' => 'bail|nullable|string',
            'lastName' => 'bail|nullable|string|max:255',
            'image' => 'nullable|file:2048|mimes:jpg,jpeg,png',
            'gender' => 'nullable|string',
            'dob' => 'nullable|before:' . Carbon::now()->subYears(10)->format('Y-m-dTH:i'),
            'email' => 'nullable|string|email|unique:users,email,' . Auth::user()->id,
            'deviceName' => 'nullable|string',
            'deviceToken' => 'nullable|string',
            'deviceType' => 'nullable|in:android,ios',
            'lat' => 'nullable|string',
            'long' => 'nullable|string',
            
        ];
    }
}
