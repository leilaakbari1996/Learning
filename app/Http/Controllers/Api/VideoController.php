<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public static function GetVideo(Request $request,$limit=5,$where=null)
    {
        $video = Video::GetVideo($limit,$where)->first();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $video
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
}
