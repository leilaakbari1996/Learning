<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Course;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public static function GetTag(Request $request,Blog $blog,$limit=4)
    {
        $tags = $blog->Tags($limit)->get();

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

    public static function GetBlog(Request $request,$limit = 5,$where=null)//Get Blog according to where
    {
        $blogs = Blog::GetBlogs($limit,$where)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $blogs
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedBlog(Request $request,Blog $blog,$limit = 5)
    {
        $blogsRelated = $blog->BlogRelated($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $blogsRelated
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedCourse(Request $request,Blog $blog,$limit=5)
    {
        $coursesRelated = $blog->CoursesRelated($limit);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $coursesRelated
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedPodcast(Request $request,Blog $blog,$limit = 5)
    {
        $podcastRelated = $blog->RelatedPodcasts($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $podcastRelated
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function RelatedGuidance(Request $request,Blog $blog,$limit=5)
    {
        $guidanceRelated = $blog->RelatedGuidances($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $guidanceRelated
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetComments(Request $request,Blog $blog)
    {
        $comments = $blog->Comments()->get();
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




    /******End***/

    /*
     * public static function GetBlogs($limit = 5,$where=null)
    {
        if(!$where){
            return self::query()->where('IsEnable',true)->orderByDesc('Order')
                ->limit($limit);
        }
        return self::query()->where('IsEnable',true)
            ->where($where)->orderByDesc('Order')->limit($limit);
    }*/










}
