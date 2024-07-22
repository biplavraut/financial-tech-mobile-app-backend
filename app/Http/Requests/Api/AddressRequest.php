<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'type' => 'bail|required|in:permanent,current',
            'provinceNo' => 'nullable|string',
            'province' => 'nullable|string',
            'zone' => 'nullable|string',
            'district' => 'nullable|string',
            'vdcMunicipality' => 'nullable|string',
            'ward' => 'nullable|string',
            'streetTole' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'tel' => 'nullable|string',
            'mobile' => 'nullable|string',
            'email' => 'nullable|string',
        ];
    }
}
