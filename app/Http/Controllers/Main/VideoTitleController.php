<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\VideoTitleController as VideoTitleApi;
use \App\Http\Controllers\Api\VideoController as VideoApi;
use \App\Http\Controllers\Api\CourseController as CourseApi;

class VideoTitleController extends Controller
{
    public function index(Request $request,$slugCourse=null,$slug=null)
    {
        $course = CourseApi::GetCourses($request,['Slug'=>$slugCourse],1)['data'][0];
        if(empty($course)){
            abort(404);
        }
        if($slug==null){
            $videoTitle = VideoTitleApi::GetVideoTitle($request,$course)['data'];
        }else {
            $videoTitle = VideoTitleApi::GetVideoTitle($request, $course, 1, ['Title' => $slug])['data'];
        }
        $videos = VideoTitleApi::GetVideos($request,$videoTitle,10)['data'];

        return  view('videoTitle',compact('videoTitle','videos'));
    }
}
