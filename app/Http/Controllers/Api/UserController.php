<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UserRequest;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function GetUsersByRole(Request $request,$limit = 10,$where = null)
    {
        $masters = User::GetUsersByRole($limit,$where)->get();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $masters
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetOrders(Request $request,User $user,$limit = 10)
    {
        $orders = $user->Orders;
        $orderPayed = $orders->where('Status','Payed');
        $orderNotPayed = $orders->where('Status','NotPayed');
        $item =[
            'payed' => $orderPayed,
            'notPayed' => $orderNotPayed
        ];
        $response = [
            'status' => 1,
            'text' => "",
            "data" => $item
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetCourses(Request $request,User $user,$orders,$limit = 10)//Courses sold by $user(auth()->user)
    {

        $courses = Course::GetCoursesByOrder($orders['payed'],$limit)->get();
        $coursesFree = Course::GetCoursesByOrder($orders['notPayed'],$limit,['IsFree'=>true])->get();
        $courses = $courses->merge($coursesFree);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $courses
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function Likes(Request $request,User $user,$limit=10)
    {
        $item = [];
        $item['blogs'] = $user->LikedBlog;
        $item['podcasts'] = $user->LikePodcat;
        $item['courses'] = $user->LikedCourses;

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $item
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function update(UserRequest $request,User $user)
    {
        $validateData = $request->validated();

        //--------------- <editor-fold description="save Image Profile">--------------//
        if($request->hasFile('ProfileURL')){
            $folderTime = folderTime();
            $image = $validateData['ProfileURL'];
            $imageAddress = "./uploads/".$folderTime."/users/profile/";
            $image = save_image($imageAddress,$image)[0];
            $validateData = delete_add_validateData($validateData,'ProfileURL',$image);
        }
        //---------------- </editor-fold> -------------------------//

        $user->update($validateData);

        $response = [
            'status' => 1,
            'text' => $user,
            "data" => $user->FirstName.' successfully updated.'
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;

    }

    public static function destroy(Request $request,User $user)
    {

        $user->IsEnable = 0;
        $user->save();

        $response = [
            'status' => 1,
            'text' => $user,
            "data" => $user->FirstName.' successfully delete.'
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;

    }


    /**end*/




    public static function GetVideos(Request $request,User $user,$orders,$limit = 10)
    {

        $videos = Video::GetVideosByOrders($orders['payed'],$limit)->get();
        $videosFree = Video::GetVideosByOrders($orders['notPayed'],$limit,['IsFree'])->get();
        $videos = $videos->merge($videosFree);

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

    public static function Saves(Request $request,User $user,$limit=10)
    {
        $item = [];
        $item['blogs'] = $user->SaveBlog;
        $item['podcasts'] = $user->SavePodcast;
        $item['courses'] = $user->SaveCourses;

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $item
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }





    public static function GetMastersByCourse(Request $request,Course $course,$limit = 10)
    {
        $masters = $course->Masters;

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $masters
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

}
