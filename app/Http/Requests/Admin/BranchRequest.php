<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'bank'=> 'bail|required|string',
            'title' => 'bail|required|string|max:255',
            'slug' => 'bail|nullable|max:255',
            'phone' => 'bail|nullable',
            'mobile' => 'bail|nullable',
            'display' => 'bail|nullable',
            'locker' => 'bail|nullable',
            'atm' => 'bail|nullable',
            'head_office' => 'bail|nullable',
            'district' => 'bail|nullable',
            'municipality' => 'bail|nullable',
            'province' => 'bail|nullable',
            'lat' => 'bail|nullable',
            'long' => 'bail|nullable',
            'address' => 'bail|nullable|string',
            'description' => 'bail|nullable|string',
        ];
    }
}
