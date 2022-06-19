<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\VideoTitleRequest;
use App\Models\Course;
use App\Models\VideosTitle;
use Illuminate\Http\Request;

class VideoTitleController extends Controller
{
    public function index(Course $course)
    {

        $videoTitles = VideosTitle::GetVideoTitle($course)->get();
        $videoTitles = separate_parent_child($videoTitles);

        return view('panel.videoTitle.index',compact('videoTitles','course'));
    }

    public function show(Course $course,VideosTitle $videosTitle)
    {
        \Head::SetTitle($videosTitle->id);

        return view('panel.videoTitle.show',compact('videosTitle','course'));
    }

    public function update(Course $course,VideosTitle $videosTitle,VideoTitleRequest $request)
    {
        $validateData = $request->validated();

        $validateData['course_id'] = $course->id;

        $videosTitle->update($validateData);

        $response = [
            'status' => 1,
            'text' => $videosTitle,
            'data' => 'The VideoTitle was successfully update'
        ];

        return $response;
    }

    public function destroy(Course $course,VideosTitle $videosTitle)
    {
        //--------------- <editor-fold description="check not parent">--------------//
        $isParent = VideosTitle::query()->where('parent_id',$videosTitle->id)->exists();
        $countVideos = $videosTitle->Videos()->count();

        if($isParent && $countVideos != 0){
            $response = [
                'status' => 0,
                'text' => $videosTitle,
                'data' => 'The VideoTitle is Parent'
            ];
        }else{

            $videosTitle->delete();

            $response = [
                'status' => 1,
                'text' => $videosTitle,
                'data' => 'The VideoTitle successfuly.'
            ];
        }
        //---------------- </editor-fold> -------------------------//

        return $response;
    }

}
