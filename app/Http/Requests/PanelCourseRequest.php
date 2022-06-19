<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanelCourseRequest extends FormRequest
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

            'Title' => 'required|min:2|string',
            'Description' => 'nullable|string|min:3',
            'AfterBuyDescription'=> 'nullable|string|min:3',
            'Price' => 'required|integer|min:0',
            'Discount' => 'required|numeric|min:0|max:100',
            'Images' => 'nullable',
            'Images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Videos' => 'nullable',
            'Videos.*' => 'nullable|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-ms-wmv,video/avi',
            'PreviewImageURl' => 'required_without:edit',
            'Type'=> 'nullable|in:Online,Offline',
            'Order'=> 'nullable|numeric|min:1',
            'TotalTime' => 'nullable|integer|min:0',
            'IsFree' => 'nullable|boolean',
            'IsSpecial' => 'nullable|boolean',
            'IsNew' => 'nullable|boolean',
            'IsEnable' => 'nullable|boolean',
            'Level'=>'nullable|in:Beginner,Intermediate,Advance,BegToAdvance',
            'Status'=>'nullable|in:End,Beginning,During',
            'UpdateDate' => 'nullable|date',
            'SeoTitle'=>'nullable|string|min:2',
            'SeoDescription'=>'nullable|min:3',
            'VideoTitles' => 'nullable',
            'FAQ' => 'required|json',
            'Tags' => 'nullable|array',
            'RelatedCourses' => 'nullable|array',
            'RelatedCourses.*' => 'exists:courses,id',
            'RelatedPodcasts' => 'nullable|array',
            'RelatedPodcasts.*' => 'nullable|exists:podcasts,id',
            'RelatedBlogs' => 'nullable|array',
            'RelatedBlogs.*' => 'nullable|exists:blogs,id',
            'RelatedGuidances' => 'nullable|array',
            'RelatedGuidances.*' => 'nullable|exists:guidances,id',
            'Categories' => 'required|array',
            'Categories.*' => 'exists:courses_categories,id',


        ];

    }
}
