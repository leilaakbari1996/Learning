<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\CartController as CartApi;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $courses = CartApi::GetCourses($request,$user)['data'];
        $videos = CartApi::GetVideos($request,$user)['data'];

        return view('client.cart',compact('courses','videos'));
    }


    
}
