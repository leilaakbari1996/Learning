<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CoursesCategory;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public static function GetSpecialCourses(Request $request,$limit = 10)
    {
        $courses = Course::GetSpecialCourses($limit);

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

    public static function GetCourses(Request $request,$where=null,$limit=10)
    {
        $courses = Course::GetAllCoursesByEnable(true,$where)->limit($limit)->get();

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

    public static function GetAllCoursesByColumn(Request $request,$categories,$column,$limit = 5)
    {//Get Courses according column = true
        $courses = Course::GetCoursesByCategoryAndChilds($categories,$limit,[$column => true]);
        $l = $limit - $courses->count() ;

        if($l > 0){
            $ids = $courses->pluck('id')->all();
            $relatedCourses = Course::GetCourses($ids,$l,$column);
            $courses = $courses->merge($relatedCourses);
        }

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

    public static function GetTheMost(Request $request,$categories,$column,$limit = 5)
    {//Get The Most Courses According Column

        $course = Course::GetTheMostCourses($categories,$column,$limit);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $course
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetCoursesByCategory(Request $request,CoursesCategory $category,$limit = 10,$column=null)
    {//When Click on the one Special Category Get Courses => js...//Courses This Category And Courses Childs.../
        ////Courses This Category And Courses Childs.And Sort By Column => js
        $courses = Course::GetMostCoursesByCategory($category,$limit,$column);


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

    /******End********/
    public static function GetCourseBySlug(Request $request,$slug = '')
    {

        $course = Course::GetCourseBySlug($slug);

        if(!$course) abort(403);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $course
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;

    }

    public static function GetCategoriesCourse(Request $request,Course $course)
    {
        $result = [];
        $category = $course->Categories()->first();
        if(!$category){
            $result = [];
        }else{
            $result [] = $category;
            $parents = CoursesCategory::Parents($category,[]);
            foreach ($parents as $parent){
                $result [] = $parent;
            }
            $result = array_reverse($result);
        }


        $response = [
            'status' => 1,
            'text' => "",
            "data" => $result
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetVideoTitle(Request $request,Course $course)
    {
        $videoTitle = $course->VideosTitile;

        $item = separate_parent_child($videoTitle);

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

    public static function RelatedCourseByCategory(Request $request,Course $course,$limit = 5)
    {
        $courses = $course->RelatedCourse($limit);
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

    public static function RelatedBlog(Request $request,Course $course,$limit=5)
    {
        $blogs = $course->RelatedBlog()->limit($limit)->get();
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

    public static function RelatedPodcast(Request $request,Course $course,$limit = 5)
    {
        $podcasts = $course->RelatedPodcast($limit);
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

    public static function RelatedGuidances(Request $request,Course $course,$limit = 5,$where=null)
    {
        $guidances = $course->RelatedGuidances($limit,$where)->get();
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

    public static function GetTags(Request $request,Course $course,$limit = 4)
    {
        $tags = $course->Tags($limit)->get();
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

    public static function GetCategories(Request $request)
    {
       // $categories = CoursesCategory::GetCategories();
        $result = [];
        $categoriesAll = CoursesCategory::GetCategoryIsEnable(true);
        $categories = $categoriesAll->get();
        foreach ($categories as $category){
            if($category->parent_id == null){
                $item = [
                    'parent' => $category,
                    'children' => []
                ];
                $item['children'] = $category->Children;
                $result[] = $item;
            }
        }
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $result
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetFreeCources(Request $request,$categories,$limit = 5)
    {
        $result = [];
        foreach ($categories as $category)
        {
            $item = [
                "category" => $category,
                "courses" => []
            ];

            $item['courses'] = Course::GetFreeCourses($category,5);
            $result[] = $item;
        }
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $result
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;

    }

    public static function GetNewCourses(Request $request,$categories,$limit = 5)
    {
        $result = [];
        foreach ($categories as $category){
            $item = [
                'category' => $category,
                'courses' =>  Course::GetNewCourses($category,5)
            ];
            $result[] = $item;
        }
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $result
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetMostSoldCourses(Request $request,$categories,$limit = 5)
    {
        $result = [];

        foreach ($categories as $category){
            $item = [
                'category' => $category,
                'courses' =>  Course::GetMostCourses($category,'NumberOfBuys',5)
            ];
            $result[] = $item;
        }
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $result
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetMostDiscopuntCourses(Request $request,$categories,$limit = 5)
    {
        $result = [];
        foreach ($categories as $category){
            $item = [
                'category' => $category,
                'courses' =>  Course::GetMostCourses($category,'Discount',5)
            ];
            $result[] = $item;
        }
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $result
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }







    public static function GetTheMostByCategory(Request $request,CoursesCategory $category,$limit = 5,$column = null)
    {//When Click on the one Special Category Get Courses => js
        $courses = Course::GetCoursesTheMostByClick($category,$column,$limit);
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

    public static function GetComments(Request $request,Course $course)
    {
        $comments = $course->Comments()->get();
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

    public static function GetUsers(Request $request,Course $course,$limit = 20)
    {
        $orders = $course->Order()->get();

        $users = User::GetUsersByOrders($orders);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $users
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetCoursesByCategoryAndChilds(Request $request,$category,$categories,$limit=20)
    {
        $categories = $categories->push($category);
        $courses = Course::GetCoursesByCategoryAndChilds($categories,$limit);

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
