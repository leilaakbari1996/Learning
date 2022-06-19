<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Course;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{

    public static function GetPodcast(Request $request,$limit=5,$where=null)//Get Podcasts Enable according to where
    {
        $podcasts = Podcast::GetPodcast($limit,$where)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcasts
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedPodcast(Request $request,Podcast $podcast,$limit= 5)
    {
        $podcasts = $podcast->RelatedPodcasts($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcasts
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetTag(Request $request,Podcast $podcast,$limit = 4)
    {
        $tags = $podcast->Tags($limit)->get();
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $tags
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedCourse(Request $request,Podcast $podcast,$limit=5)
    {
        $podcasts = $podcast->RelatedCourses($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcasts
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedBlog(Request $request,Podcast $podcast,$limit =5)
    {
        $podcasts = $podcast->RelatedBlog($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcasts
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedGuidance(Request $request,Podcast $podcast,$limit =5)
    {
        $podcasts = $podcast->RelatedGuidances($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcasts
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
    /*********End**/



    public static function GetPodcastBySlug(Request $request,$slug)
    {
        $podcasts = Podcast::GetPodcast(1,['Slug'=>$slug])->first();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcasts
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }





    public static function GetComments(Request $request,Podcast $podcast)
    {
        $comments = $podcast->Comments()->get();
        $array = separate_parent_child($comments);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $array
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
}
