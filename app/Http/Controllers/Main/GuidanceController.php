<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\GuidanceController as GuidanceApi;

class GuidanceController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('Guidance');
        $guidances = GuidanceApi::GetGuidance($request,20)['data'];

        return view('client.guidance.index',compact('guidances'));
    }

    public function show(Request $request,$slug)
    {
        \Head::GetTitle('Guidance');
        $guidance = GuidanceApi::GetGuidance($request,1,['Slug' => $slug])['data'];
        $guidance = $guidance[0];
        if(empty($guidance)){
            abort(404);
        }
        $courses = GuidanceApi::GetCourses($request,$guidance,5)['data'];
        $relatedGuidance = GuidanceApi::RelatedGuidance($request,$guidance,5)['data'];
        $relatedPodcast = GuidanceApi::RelatedPodcast($request,$guidance,5)['data'];
        $relatedBlog = GuidanceApi::RelatedBlog($request,$guidance,5)['data'];
        $relatedCourse = GuidanceApi::RelatedCourse($request,$guidance,5)['data'];

        return view('client.guidance.show',compact('guidance','courses','relatedGuidance'
        ,'relatedBlog','relatedPodcast','relatedCourse'));
    }
}
