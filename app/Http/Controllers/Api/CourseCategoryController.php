<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CoursesCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public static function GetSpecialCategory(Request $request,$limit = 5)
    {
        $categories = CoursesCategory::GetSpecialCategory($limit);

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

    public static function GetCategories(Request $request,$limit = 10)
    {//Get All Categorires => IsEnable = true
        $categories = CoursesCategory::GetCategoryIsEnable(true)->get();
        $item = separate_parent_child($categories);//ordering Categories According to Childs

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $item
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function Parents(Request $request,CoursesCategory $category,$array = [])
    {
        $parents = CoursesCategory::Parents($category,$array);
        $parents = array_reverse($parents);
        $parents[] =$category;

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $parents
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetChildrensByParent(Request $request,CoursesCategory $category,$limit=10)
    {
        $children = $category->Children;

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $children
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
    /*******#nd*****************/
    public static function GetCategory(Request $request,$where=null)
    {
        $category = CoursesCategory::GetCategory($where)->first();//Get Category By Slug

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $category
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }





    public function GetCategoryBySlug($slug)
    {
        /*$category = CoursesCategory::GetCategoryBySlug($slug);
        $parents = CoursesCategory::Parents([],$category);
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $course
        ];

        /*if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;*/

    }








}
