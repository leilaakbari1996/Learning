<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UserRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class UserController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست کاربران');
        $users = User::GetUsersByRole(20)->get();

        return  view('panel.user.index',compact('users'));
    }

    public function show(User $user)
    {
        \Head::SetTitle($user->FirstName);
        $likeBlogs = $user->LikedBlog;
        $likePodcasts = $user->LikedPodcast;
        $likeCourses = $user->LikedCourses;

        $saveBlogs = $user->SaveBlog;
        $savePodcasts = $user->SavePodcast;
        $saveCourses = $user->SaveCourses;

        $coursesTeaching = collect([]);
        if($user->IsMaster)
        {
            $coursesTeaching = $user->CoursesByMaster()->get();
        }

        return view('panel.user.show',compact('user','likeCourses','saveCourses',
            'likePodcasts','likeBlogs','saveBlogs','savePodcasts','coursesTeaching'));
    }

    public function edit(User $user)
    {
        \Head::SetTitle($user->FirseName);

        return view('panel.user.edit',compact('user'));
    }

    public function update(User $user,UserRequest $request)
    {
        $validateData = $request->validated();
        if($request->get('course')) {
            $course = $validateData['course'];
            unset($validateData['course']);
        }
        if($request->get('video')) {
            $video = $validateData['video'];
            unset($validateData['video']);
        }

        $user->update($validateData);

        //--------------- <editor-fold description="Add Course Or Video To order">--------------//
        if(!empty($course) || !empty($video)) {
            $order = Order::create([
                'Email' => $user->Email,
                'PhoneNumber' => $user->PhoneNumber,
                'TotalPrice' => 0,
                'Discount' => 0,
                'user_id' => $user->id,
                'Status' => 'Payed'
            ]);
        }

        if(!empty($course)) {

            $order->Courses()->attach($course, [
                'Count' => 1,
                'Discount' => 0,
                'Price' => 0,
            ]);
        }

        if(!empty($video)){
            $order->Videos()->attach($video, [
                'Count' => 1,
                'Price' => 0,
                'Discount' => 0
            ]);
        }

        //---------------- </editor-fold> -------------------------//

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'updated successfull'
        ];

        return  $response;
    }

    public function admin(User $user,Request $request)
    {
        $validataData = $request->validate([
            'value' => 'required|in:true,false'
        ]);
        if($validataData['value'] == 'true'){
            $user->update([
                'IsAdmin' => true
            ]);
            $data = $user->FirstName.' successfully became an administrator';
        }else{
            $user->update([
                'IsAdmin' => false
            ]);
            $data = $user->FirstName.' successfully Delete administrator';
        }

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }

    public function master(User $user,Request $request)
    {

        $validataData = $request->validate([
            'value' => 'required|in:true,false'
        ]);
        if($validataData['value'] == 'true'){
            $user->update([
                'IsMaster' => true
            ]);
            $data = $user->FirstName.' successfully became an master';
        }else{
            $user->update([
                'IsMaster' => false
            ]);
            $data = $user->FirstName.' successfully Delete master';
        }

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }

    public function destroy(User $user,Request $request)
    {
        $user->IsEnable = 0;
        $user->save();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $user->FirstName.' was successfully removed'
        ];

        return  $response;

    }

    public function adminIndex()
    {
        $admins = User::GetUsersByRole(20,['IsAdmin'=>true])->get();

        return view('panel.user.admin',compact('admins'));
    }

    public function adminDelete(User $user)
    {
        $user->update([
            'IsAdmin' => false
        ]);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $user->FirstName.' successfully remove of administrator'
        ];

        return  $response;
    }

    public function masterIndex()
    {
        $masters = User::GetUsersByRole(20,['IsMaster'=>true])->get();

        return view('panel.user.master',compact('masters'));
    }

    public function masterDelete(User $user)
    {
        $user->update([
            'IsMaster' => false
        ]);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $user->FirstName.' successfully remove of master'
        ];

        return  $response;
    }
}
