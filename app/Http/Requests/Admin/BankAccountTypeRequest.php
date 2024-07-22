<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountTypeRequest extends FormRequest
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
        $modelId = last(request()->segments());
        return [
            //
            'bank' => 'bail|required|string',
            'account_type' => 'bail|required|string',
            'title'             => 'bail|required|string|max:255',
            'slug'            => 'bail|nullable|max:255',
            'image'       => 'bail|' . ($modelId ? 'nullable' : 'required') . '|max:2048|mimes:png,jpg,jpeg,webp',
            //'image'             => 'bail|nullable|file|max:2048|mimes:png,jpg,jpeg,webp',
            'display' => 'bail|nullable',
            'description' => 'bail|nullable|string',
            'attribute' => 'bail|nullable|array',
        ];
    }
}
