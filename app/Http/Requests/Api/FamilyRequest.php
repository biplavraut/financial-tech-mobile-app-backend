<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
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
            'kycId' => 'bail|required|string',
            'relation' => 'bail|required|in:spouse,father,mother,grand_father,grand_mother,son,daughter,daughter_in_law,father_in_law,mother_in_law',
            'fullName' => 'nullable|string',
            'citizenshipNo' => 'nullable|string',
            'placeOfIssue' => 'nullable|string',
            'dateOfIssue' => 'nullable|string',
            'contact' => 'nullable|string'
        ];
    }
}
