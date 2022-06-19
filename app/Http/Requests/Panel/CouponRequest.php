<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'Title' => 'required|string|min:2',
            'Count' => 'nullable|numeric|min:1',
            'Type' => 'nullable|in:Code,Bill',
            'Amount' => 'required|integer|min:1',
            'StartDate' => 'nullable|date|before:EndDate|after:today',
            'EndDate' => 'nullable|date|after:StartDate',
            'IsEnable' => 'nullable|boolean',
            'MinOrder' => 'nullable|integer'
        ];
    }
}
