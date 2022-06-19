<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'Email' => 'nullable|email',
            'PhoneNumber' => 'nullable',
            'Subject' => 'required|min:3',
            'Text' => 'required|min:5',
            'Name' => 'required|min:2|string'
        ];
    }
}
