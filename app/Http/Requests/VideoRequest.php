<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            'Time' => 'nullable',
            'Price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'video_title_id' => 'required|exists:videos_titles,id',
            'Order' => 'nullable|numeric|min:1',
            'IsEnable' => 'nullable|boolean',
            'IsFree' => 'nullable|boolean',
            'VideoURL' => 'required_without:edit',
            'Title' => 'required|string|min:2',
        ];
    }
}
