<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BimaRequest extends FormRequest
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
            'routing_no'            => 'bail|nullable|max:255',
            'logo'             => 'bail|nullable|file|max:2048|mimes:png,jpg,jpeg,webp',
            'banner'             => 'bail|nullable|file|max:2048|mimes:png,jpg,jpeg,webp',
            'phone' => 'bail|nullable',
            'mobile' => 'bail|nullable',
            'display' => 'bail|nullable',
            'featured' => 'bail|nullable',
            'rating' => 'bail|nullable',
            'type' => 'bail|nullable',
            'lat' => 'bail|nullable',
            'long' => 'bail|nullable',
            'address' => 'bail|nullable|string',
            'secondary_address' => 'bail|nullable|array',
            'description' => 'bail|nullable|string',
            'attribute' => 'bail|nullable|array',
        ];
    }
}
