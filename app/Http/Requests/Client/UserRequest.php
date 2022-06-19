<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ProfileURL' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Wallet' => 'nullable|integer',
            'FirstName' => 'nullable|string|min:2',
            'LastName' => 'nullable|string|min:2',
            'PhoneNumber'=>'required|unique:users,PhoneNumber',
            'Email' => 'nullable|unique:users,Email',

        ];
    }
}
