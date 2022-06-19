<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'LastName' => 'required|min:2|max:100',
            'FirstName' => 'required|min:2|max:160',
            'Email' => 'required|min:2|unique:users,Email',
            'PhoneNumber' => 'required|unique:users,PhoneNumber||regex:/(09)[0-9]{9}/'


        ];
    }
}
