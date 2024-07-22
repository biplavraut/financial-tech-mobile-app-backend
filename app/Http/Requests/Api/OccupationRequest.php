<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OccupationRequest extends FormRequest
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
            'type' => 'bail|required|in:government,private,public,student,teacher_professor,self,other',
            'office' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'estAnnualIncome' => 'nullable|string',
            'estAnnualTurnover' => 'nullable|string',
            'tel' => 'nullable|string'
        ];
    }
}
