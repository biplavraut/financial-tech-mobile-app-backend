<?php

namespace App\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class KycRequest extends FormRequest
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
            'salutation' => 'bail|nullable|string',
            'firstName' => 'bail|required|string|max:255',
            'middleName' => 'bail|nullable|string',
            'lastName' => 'bail|required|string|max:255',
            'gender' => 'bail|nullable|string',
            'nationality' => 'bail|nullable|string',
            'maritalStatus' => 'bail|nullable|string',
            'dobBs' => 'bail|nullable|date_format:Y-m-d',
            'dobAd' => 'bail|nullable|before:' . Carbon::now()->format('Y-m-dTH:i'),
            'self' => 'bail|nullable|string',
            'other' => 'bail|nullable|string',
            'ppPhoto' => 'bail|nullable|file:2048|mimes:jpg,jpeg,png',
            'map' => 'bail|nullable|file:2048|mimes:jpg,jpeg,png',
            'countryCode'       => 'bail|nullable|string|min:2',
            'phone'       => 'bail|nullable|string',
            'mobile' => 'bail|nullable|string',
            'email'       => 'bail|nullable|string',
            'pepsMember' => 'bail|nullable|string',
            'pepsDetail' => 'bail|nullable|string',
            'beneficial' => 'bail|nullable|string',
            'beneficialName' => 'bail|nullable|string',
            'beneficialCtznNo' => 'bail|nullable|string',
            'beneficialRelation' => 'bail|nullable|string',
            'beneficialAddress' => 'bail|nullable|string',
            'beneficialContact' => 'bail|nullable|string',
            'decleration' => 'bail|nullable|string',
            'additionalNote' => 'bail|nullable|string'
        ];
    }
}
