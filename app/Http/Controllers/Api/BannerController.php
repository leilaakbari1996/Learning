<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public static function BannerEnable(Request $request,$limit=3,$where=null)
    {
        $banners = Banner::BannerEnable($limit,$where);
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $banners
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }


}
