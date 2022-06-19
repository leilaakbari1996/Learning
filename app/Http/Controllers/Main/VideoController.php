<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\VideoController as VideoApi;


class VideoController extends Controller
{
    public function index(Request $request,$slug=null)
    {
        $video = VideoApi::GetVideo($request,1,['Title'=>$slug])['data'];
        if(empty($video)){
            abort(404);
        }

        return  view('video',compact('video'));
    }
}
