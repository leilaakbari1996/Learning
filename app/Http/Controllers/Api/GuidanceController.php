<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Guidance;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public static function GetGuidanceSpecial(Request $request,$limit=5)
    {

        $guidances = Guidance::GetGuidence($limit,['IsSpecial' => true])->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidances
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetGuidance(Request $request,$limit = 20,$where = null)
    {
        $guidance = Guidance::GetGuidence($limit,$where)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidance
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetCourses(Request $request,Guidance $guidance,$limit = 5)
    {
        $courses = $guidance->Courses($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $courses
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedGuidance(Request $request,Guidance $guidance,$limit = 5)
    {
        $guidances = $guidance->RelatedGuidances($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidances
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedPodcast(Request $request,Guidance $guidance,$limit = 5)
    {
        $guidances = $guidance->RelatedPodcasts($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidances
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedBlog(Request $request,Guidance $guidance,$limit = 5)
    {
        $guidances = $guidance->RelatedBlog($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidances
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedCourse(Request $request,Guidance $guidance,$limit = 5)
    {
        $guidances = $guidance->RelatedCourses($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidances
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
    /*********End*********/


    public static function GetGuidanceBySlug(Request $request,$slug)
    {
        $guidance = Guidance::GetGuidence(1,['Slug'=>$slug])->first();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidance
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }





    public static function GetCoursesByGuidance(Request $request,Guidance $guidance,$limit = 10)
    {
        $courses = $guidance->Courses;
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $courses
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }


}
