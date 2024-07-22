<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'title'             => 'bail|required|string|max:255',
            'slug'            => 'bail|nullable|max:255',
            'icon'             => 'bail|nullable|file|max:2048|mimes:png,jpg,jpeg,webp',
            'image'             => 'bail|nullable|file|max:2048|mimes:png,jpg,jpeg,webp',
            'display' => 'bail|nullable',
            'parent' => 'bail|nullable',
            'child' => 'bail|nullable',
            'description' => 'bail|nullable|string',
        ];
    }
}
