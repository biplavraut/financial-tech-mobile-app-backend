<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'title'             => 'bail|required|string|max:255',
            'sub_title'            => 'bail|nullable|max:255',
            'page' => 'bail|nullable|string|max:255',
            'feature' => 'bail|nullable|string|max:255',
            'image'       => 'bail|' . ($modelId ? 'nullable' : 'required') . '|max:2048|mimes:png,jpg,jpeg,webp',
            //'image'             => 'bail|nullable|file|max:2048|mimes:png,jpg,jpeg,webp',
            'link' => 'bail|nullable|string',
            'display' => 'bail|nullable'
        ];
    }
}
