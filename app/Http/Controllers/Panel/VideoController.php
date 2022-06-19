<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PanelCourseRequest;
use App\Http\Requests\VideoRequest;
use App\Models\Course;
use App\Models\Tag;
use App\Models\Video;
use App\Models\VideosTitle;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Course $course,VideosTitle $videosTitle)
    {
        \Head::GetTitle('videos');
        $videos = Video::GetVideo(20,['video_title_id' => $videosTitle->id])->get();

        return view('panel.video.index',compact('course','videosTitle','videos'));
    }

    public function show(Course $course,VideosTitle $videosTitle,Video $video)
    {
        \Head::GetTitle('videos');

        return view('panel.video.show',compact('course','videosTitle','video'));
    }

    public function create(Course $course,VideosTitle $videosTitle)
    {
        \Head::SetTitle('آپلود فایل');


        return view('panel.video.create',compact('course','videosTitle'));
    }

    public function store(VideoRequest $request)
    {

        if (!$request->hasFile('VideoUrl')) {
            return response()->json(['message' => 'Missing file'], 422);
        }
        $validateDate = $request->validated();
        $folderTime = folderTime();

        //--------------- <editor-fold description="Video">--------------//
        $video = $validateDate['VideoUrl'];
        $videoAddress = './uploads/'.$folderTime.'/videoTitles/'.$validateDate['video_title_id'].'/videos/';
        $video = move_videos($videoAddress,$video);
        $validateDate = delete_add_validateData($validateDate,'VideoUrl',$video);
        //---------------- </editor-fold> -------------------------//


        $video = Video::create($validateDate);


        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The video was successfully saved.'
        ];

        return  $response;


    }

    public function edit(Course $course,VideosTitle $videosTitle,Video $video)
    {
        \Head::GetTitle($video->Title);

        return view('panel.video.edit',compact('course','videosTitle','video'));
    }

    public function update(Course $course,VideosTitle $videosTitle,Video $video,VideoRequest $request)
    {
        $validateData = $request->validated();
        $folderTime = folderTime();

        //--------------- <editor-fold description="Video">--------------//
        $videoMain = $video->VideoURL;
        if($request->hasFile('VideoURL')) {
            $videoMain = $validateData['VideoURL'];
            $videoAddress = './uploads/'.$folderTime.'/videoTitles/' . $validateData['video_title_id'] . '/videos/';
            $videoMain = move_videos($videoAddress,$videoMain);
        }
        $validateData = delete_add_validateData($validateData,'VideoURL',$videoMain);

        //---------------- </editor-fold> -------------------------//

        $video->update($validateData);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The video was successfully update.'
        ];

        return  $response;
    }

    public function destroy(Course $course,VideosTitle $videosTitle,Video $video)
    {
        $video->delete();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The video was successfully delete.'
        ];

        return  $response;
    }

}
