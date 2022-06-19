<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\BlogController as BlogApi;
use \App\Http\Controllers\Api\BannerController as BannerApi;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('Banners');
        $banners = BannerApi::BannerEnable($request,10,['IsEnable' => true])['data'];

        return view('client.banner.index',compact('banners'));
    }

    public function show(Request $request,Banner $banner)
    {
        \Head::SetTitle($banner->Title);
        if(!$banner->IsEnable){
            abort(404);
        }

        return  view('client.banner.show',compact('banner'));
    }
}
