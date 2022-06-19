<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public static function GetBlogCategories(Request $request,$limit=10,$where=null)
    {
        $categories = BlogCategory::GetCategories($limit,$where)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $categories
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function Blogs(Request $request,BlogCategory $blogCategory,$limit=10,$where=null)
    {
        $blogs = $blogCategory->Blogs()->get();

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

}
