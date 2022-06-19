<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CourseController as CourseApi;
use \App\Http\Controllers\Api\CourseCategoryController as CategoryCourseApi;
use \App\Http\Controllers\Api\VideoTitleController as TitleApi;
use \App\Http\Controllers\Api\UserController as UserApi;
use phpDocumentor\Reflection\Types\Nullable;
use Spatie\FlareClient\Api;


class CourseController extends Controller
{
    public function index(Request $request)
    {

        \Head::SetTitle('courses');

        $courses = CourseApi::GetCourses($request,20)['data'];

        return  view('client.course.index',compact('courses'));
    }

    public function show(Request $request,$slug = "")//Categories and relatedCourse => course
    {
         \Head::SetTitle("Course");
         $course = CourseApi::GetCourseBySlug($request,$slug)['data'];
         if(empty($course)){
             abort(404);
         }
         $categoriesParent =CourseApi::GetCategoriesCourse($request,$course)['data'];
         $relatedCourse = CourseApi::RelatedCourseByCategory($request,$course,5)['data'];
         $relatedBlog = CourseApi::RelatedBlog($request,$course,5)['data'];
         $relatedPodcast =CourseApi::RelatedPodcast($request,$course,5)['data'];
         $relatedGuidance = CourseApi::RelatedGuidances($request,$course,5)['data'];
         $tags = CourseApi::GetTags($request,$course,4)['data'];
         $comments = CourseApi::GetComments($request,$course)['data'];
         $videoTitle = CourseApi::GetVideoTitle($request,$course)['data'];
         $users = CourseApi::GetUsers($request,$course,20)['data'];
         $masters = UserApi::GetMastersByCourse($request,$course,10)['data'];

         return  view('client.course.show',compact('course','categoriesParent','relatedCourse','relatedBlog',
             'relatedPodcast','relatedGuidance','tags','comments','videoTitle','users','masters'));
    }

    public function offline(Request $request)
    {

        \Head::SetTitle('course');

        $courses = CourseApi::GetCourses($request,['Type' => 'Offline'],10)['data'];//courses type=offline.


        return  view('client.courseOffline',compact('courses'));
    }


}
