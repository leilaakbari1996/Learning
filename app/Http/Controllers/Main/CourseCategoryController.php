<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Api\CourseController as CourseApi;
use \App\Http\Controllers\Api\CourseCategoryController as CategoryCourseApi;
use App\Http\Controllers\Controller;
use App\Models\CoursesCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('Categories');

        $categories = CategoryCourseApi::GetCategories($request,20)['data'];

        return view('client.category.index',compact('categories'));
    }

    public function show(Request $request,$slug)
    {
        \Head::SetTitle('Category');

        $category = CategoryCourseApi::GetCategory($request,['Slug' => $slug])['data'];
        if(empty($category)){
            abort(404);
        }
        $parent = CategoryCourseApi::Parents($request,$category)['data'];
        $children = CategoryCourseApi::GetChildrensByParent($request,$category,20)['data'];
        $courses = CourseApi::GetCoursesByCategoryAndChilds($request,$category,$children,20)['data'];
        $sortCourses = CourseApi::GetCoursesByCategory($request,$category,10,'Likes')['data'];//sort

        return view('client.category.show',compact('category','courses','parent','sortCourses','sortCourses'));
    }

}
