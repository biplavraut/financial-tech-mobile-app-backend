<?php

namespace App\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'type' => 'bail|required|in:citizenship,passport,license,pan,voter_id,national_id,birth_certificate,other',
            'number' => 'bail|required|string',
            'officeOfIssuance' => 'nullable|string',
            'dateOfIssue' => 'nullable|date_format:Y-m-d',
            'issueDistrict' => 'nullable|string',
            'front' => 'nullable|file:2048|mimes:jpg,jpeg,png,webp',
            'back' => 'nullable|file:2048|mimes:jpg,jpeg,png,webp',
            'selfiee' => 'nullable|file:2048|mimes:jpg,jpeg,png,webp',
            'validTill' =>'nullable|date_format:Y-m-d'
        ];
    }
}
