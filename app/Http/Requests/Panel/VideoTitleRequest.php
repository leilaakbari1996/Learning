<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class VideoTitleRequest extends FormRequest
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
            'IsEnable' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:videos_titles,id',
            'Order' => 'nullable|numeric|min:1',
        ];
    }
}
