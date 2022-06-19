<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'Email' => 'required|email',
            'PhoneNumber' => 'required|integer',
            'price' => 'required|min:0|integer',
            'couponId' => 'nullable|exists:coupons,id'
        ];
    }
}
