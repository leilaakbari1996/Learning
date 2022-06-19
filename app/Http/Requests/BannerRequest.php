<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'IsEnable' => 'nullable|boolean',
            'Title' => 'nullable|string|min:2',
            'Order' => 'nullable|numeric|min:1',
            'Description' => 'nullable|string',
            'ImageURL' => 'required_without:edit',
            'Link' => 'required',
        ];

    }
}
