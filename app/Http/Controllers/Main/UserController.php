<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use  \App\Http\Controllers\Api\UserController as UserApi;
use  \App\Http\Controllers\Api\CourseController as CourseApi;

class UserController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('Masters');
        $masters = UserApi::GetUsersByRole($request,10,['IsMaster' => true])['data'];//Get Masters

        return  view('masters',compact('masters'));
    }

    public function show(Request $request)
    {
        $user = auth()->user();
        if(empty($user) || !$user->IsEnable){
            abort(404);
        }

        \Head::SetTitle($user->FirstName);

        $orders = UserApi::GetOrders($request,$user,10)['data'];
        $courses = UserApi::GetCourses($request,$user,$orders,10)['data'];//Courses sold
        $videos = UserApi::GetVideos($request,$user,$orders,10)['data'];//Videos Sold
        $saves = UserApi::Saves($request,$user,10)['data'];
        $likes = UserApi::Likes($request,$user,10)['data'];

        return  view('client.user.show',compact('user','orders','courses','videos','saves','likes'));
    }

    public function edit(Request $request)
    {
        $user = auth()->user();
        if(empty($user) || !$user->IsEnable){
            abort(404);
        }
        \Head::SetTitle($user->FirstName);

        return view('client.user.edit',compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        if(empty($user) || !$user->IsEnable){
            abort(404);
        }

        UserApi::update($request,$user);
    }



}
