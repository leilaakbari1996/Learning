<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuidanceRequest extends FormRequest
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
            "Title" => 'required|string',
            'Description' => 'required|min:3',
            "ImageURL"=> 'nullable',
            'Order' => 'nullable|numeric|min:1',
            'IsEnable' => 'nullable|boolean',
            'VideoURL' =>'nullable',
            'IconURL' => 'nullable',
            'IsSpecial' => 'nullable|boolean',
            'Courses' => 'nullable|array',
            'Courses.*' => 'exists:courses,id',
            'RelatedPodcast' => 'nullable|array',
            'RelatedPodcast.*' => 'exists:podcasts,id',
            'RelatedCourses' => 'nullable|array',
            'RelatedCourses.*' => 'exists:courses,id',
            'RelatedGuidances' => 'nullable|array',
            'RelatedGuidances.*' => 'exists:guidances,id',
            'RelatedBlog' => 'nullable|array',
            'RelatedBlog.*' => 'exists:blogs,id'
        ];
    }
}
