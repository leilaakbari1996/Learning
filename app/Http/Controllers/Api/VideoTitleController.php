<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\VideosTitle;
use Illuminate\Http\Request;

class VideoTitleController extends Controller
{
    public static function GetVideoTitle(Request $request,Course$course,$limit=5,$where=null)
    {
        $videoTitle = VideosTitle::GetVideoTitle($course,$where)->first();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $videoTitle
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetVideos(Request $request,VideosTitle $videoTitle,$limit=10)
    {
         $videos = $videoTitle->Videos($limit)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $videos
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
}
