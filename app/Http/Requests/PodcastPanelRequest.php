<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PodcastPanelRequest extends FormRequest
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
            "ImageURL"=> 'required_without:edit',
            "AudioURL"=> 'required_without:edit',
            'Order' => 'nullable|numeric|min:1',
            "IsNew" => 'nullable|boolean',
            'IsEnable' => 'nullable|boolean',
            'IsSpecial' => 'nullable|boolean',
            'SeoTitle' => 'nullable|min:2|string',
            'SeoDescription' => 'nullable|min:3',
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