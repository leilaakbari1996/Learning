<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCourseRequest extends FormRequest
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
            'Title' => 'required|string',
            'parent_id'=>'nullable|exists:courses_categories,id',
            'IsEnable' => 'nullable|boolean',
            'IsSpecial' => 'nullable|boolean',
            'Order' => 'nullable|numeric|min:1',
            'Level' => 'nullable|numeric|min:1',
        ];
    }
}
