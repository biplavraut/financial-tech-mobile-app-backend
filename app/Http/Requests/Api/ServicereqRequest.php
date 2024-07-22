<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ServicereqRequest extends FormRequest
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
            //
            'kyc' => 'bail|required',
            'service' => 'nullable|string',
            'title' => 'nullable|string',
            'titleId' => 'nullable|string',
            'type' => 'nullable|string',
            'typeId' => 'nullable|string',
            'description' => 'nullable|string',
            'formFields' => 'nullable|string'
        ];
    }
}
