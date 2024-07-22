<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password'              => 'bail|required|string|min:6',
            'new_password'              => 'bail|required|string|min:6|same:new_password_confirmation',
            'new_password_confirmation' => 'bail|required|string|min:6',
        ];
    }
}
